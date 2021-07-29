<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Message;
use App\Guest;
use App\ChatRequest;
use App\User;
use DataTables;

class MessageController extends Controller
{

	public function __construct()
    {
      $this->middleware('admin')->only('chat_history','remove_history','get_chat_history_data');
    }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function chat(Request $request,$chat_request_id)
    {
       date_default_timezone_set(get_option('timezone'));		
	   $chat_request = ChatRequest::find($chat_request_id);
	   
	   if($chat_request->operator_id == NULL){
			$chat_request->status = 'chat_start'; 
			$chat_request->operator_id= Auth::user()->id;
			$chat_request->save();
			
			$message = new Message();
		    $message->chat_request_id = $chat_request_id;
		    $message->message = Auth::user()->name." "._lang('has joined to chat conversation');
		    $message->status = 0;
		    $message->sender = "operator";
		    $message->receiver = "guest";
		    $message->save();
			
			$messages = Message::where("chat_request_id",$chat_request_id)->get();
		    Message::where('chat_request_id',$chat_request_id)->update(['status' => 1]);
 
	        $request->session()->put('operator_chat_request_id',$chat_request_id); 
	        echo json_encode(array("messages"=>$messages,"access"=>"true"));
	   }else if($chat_request->operator_id == Auth::user()->id){
		   
		   //Check if this is a transfer chat
		   if($chat_request->status == 'chat_transfer'){
			  $chat_request->status = 'chat_start'; 
		      $chat_request->operator_id = Auth::user()->id;
		      $chat_request->save();
			  
			  $message = new Message();
		      $message->chat_request_id = $chat_request_id;
		      $message->message = Auth::user()->name." "._lang('has joined to chat conversation');
		      $message->status = 0;
		      $message->sender = "operator";
		      $message->receiver = "guest";
		      $message->save();  
		   } 

		   $messages = Message::where("chat_request_id",$chat_request_id)->get();
		   Message::where('chat_request_id',$chat_request_id)->update(['status' => 1]);
 
	       $request->session()->put('operator_chat_request_id',$chat_request_id); 
	       echo json_encode(array("messages"=>$messages,"access"=>"true"));
	   }else{
		   echo json_encode(array("access"=>"false"));
	   }
    }
	
	public function get_messages($chat_request_id,$last_id=0){
	   \DB::beginTransaction();
	   $messages = Message::join("chat_requests","messages.chat_request_id","chat_requests.id")
	                        ->select("messages.*","chat_requests.guest_is_typing")
							->where("messages.chat_request_id",$chat_request_id)
	                        ->where("messages.id",">",$last_id)->get();
	   
	   
	   Message::where('chat_request_id',$chat_request_id)->update(['status' => 1]);
	   echo json_encode($messages);
	   \DB::commit();
	}
	
	public function end_chat(Request $request, $chat_request_id)
    {
       date_default_timezone_set(get_option('timezone'));		
	   ChatRequest::where('id',$chat_request_id)->update(['status' => 'chat_end']);
	   $message = new Message();
	   $message->chat_request_id = $chat_request_id;
	   $message->message = "<span class='chat_ended'><i class='fa fa-sign-out'></i> ".Auth::user()->name." "._lang('has ended chat session.')."</span>";
	   $message->status = 0;
	   $message->sender = "operator";
	   $message->receiver = "guest";
	   $message->save();
	   $request->session()->forget('operator_chat_request_id');
	   echo $message->message;
    }
	
	public function send_message(Request $request){
	   date_default_timezone_set(get_option('timezone'));
	   $message = new Message();
	   $message->chat_request_id = $request->chat_request_id;
	   
	   if(startsWith($request->message,"<img") || startsWith($request->message,"<a")){
		   $message->message = $request->message;
	   }else{
		   $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
		   $msg_string = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $request->message);
		   $message->message = $msg_string;
	   }
	   
	   $message->status = 0;
	   $message->sender = "operator";
	   $message->receiver = "guest";
	   $message->save();
	   echo "send"; 	   
	}
	
	public function upload_file(Request $request){
		$max_size = get_option('max_upload_size')*1024;
		$supported_file_types = get_option('file_type_supported');
		
		$validator = Validator::make($request->all(), [
			'file' => "required|max:$max_size|mimes:$supported_file_types",
		]);
		
		if ($validator->fails()) {
			return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);				
		}
		
		$file = $request->file('file');
		$file_name = "Attachment_".time().'.'.$file->getClientOriginalExtension();
		$file->move(base_path('uploads/chat_files/'),$file_name);
		
		$msg_text = "<a target='_blank' href='".asset("uploads/chat_files/$file_name")."'>$file_name</a>";
		
		date_default_timezone_set(get_option('timezone'));
		$message = new Message();
	    $message->chat_request_id = $request->session()->get('operator_chat_request_id');
	    $message->message = $msg_text;
	    $message->status = 0;
	    $message->sender = "operator";
	    $message->receiver = "guest";
	    $message->save();
		
		return response()->json(['result'=>'success','file'=>$file_name,'file_path'=>"/uploads/chat_files/".$file_name,'message'=>'Uploaded Sucessfully']);    
	}
	
	public function chat_transfer_window(Request $request){
		if($request->ajax()){
			return view('backend.chat_transfer.modal.chat_transfer');
		} 
	}
	
	public function transfer_chat($chat_request_id,$operator_id,$guest_id){
		$operator = User::find($operator_id);
		
		$chat_request = ChatRequest::find($chat_request_id);
		$chat_request->status = 'chat_transfer';
		$chat_request->operator_id = $operator_id;
		if(get_option('allow_department') == 'yes'){
			$guest = Guest::find($guest_id);
			$guest->department_id = $operator->department_id;
			$guest->save();
		}
		$chat_request->save();
		
	
		$message = new Message();
		$message->chat_request_id = $chat_request_id;
		$message->message = Auth::user()->name." "._lang('has transfered chat to')." ".$operator->name;
		$message->status = 0;
		$message->sender = "operator";
		$message->receiver = "guest";
		$message->save();
		
		echo 'chat_transfer';
		
	}
	
	
	/** Admin Action **/
	public function chat_history($id=""){
		if($id == ""){
			return view('backend/history/chat_history');
		}else{
			$chat_history = ChatRequest::join("guests","guests.id","chat_requests.guest_id")
			                           ->leftJoin("users","users.id","chat_requests.operator_id")
			                           ->leftJoin("messages","chat_requests.id","messages.chat_request_id")
									   ->select('messages.*','guests.name as guest','users.name as operator','chat_requests.*')
									   ->where("guests.company_id",company_id())
									   ->where("chat_requests.id",$id)->get();
			if(count($chat_history) > 0){						   
				return view('backend/history/single_chat_history',compact('chat_history'));
		    }else{
				abort(404);
			}
		}
	}
	
	public function get_chat_history_data(){
		$chat_history = ChatRequest::with("guest")
								   ->with("operator")
								   ->join("guests","guests.id","chat_requests.id")
								   ->select('chat_requests.*')
								   ->where("guests.company_id",company_id())
								   ->orderBy("chat_requests.id","desc");
		
		return Datatables::eloquent($chat_history)
						->editColumn('guest.url', function ($history) {
							return ('<a href="'.isset($history->guest->url) ? $history->guest->url : '' .'">'.isset($history->guest->url)) ? $history->guest->url : '' .'</a>';
						})
						->editColumn('operator.name', function ($history) {
							return $history->operator !='' ? $history->operator->name : '';
						})
						->editColumn('status', function ($history) {
							return ucwords(str_replace("_"," ",$history->status));
						})
						->addColumn('view', function ($history) {	
							return '<a href="'.url('message/chat_history/'.$history->id) .'" class="btn btn-primary btn-xs">'._lang('View') .'</a>';
						})
						->addColumn('delete', function ($history) {	
							return '<a href="'.url('message/remove_history/'.$history->id) .'" class="btn btn-danger btn-xs">'._lang('Delete') .'</a>';
						})
						->setRowId(function ($trans) {
							return "row_".$trans->id;
						})
						->rawColumns(['url','view','delete'])
						->make(true);	
	}
	
	public function remove_history($request_id){
		$chat_request = ChatRequest::find($request_id);
		$guest_id = $chat_request->guest_id;
		$chat_request->delete();
		
		Message::where('chat_request_id', $request_id)->delete();
		Guest::where('id', $guest_id)->delete();
		
		return redirect('message/chat_history')->with("success",_lang('History Removed Sucessfully'));
	}
	
}
