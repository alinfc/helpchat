<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OfflineMessage;
use App\Guest;
use App\ChatRequest;
use App\Message;
use App\OfflineMessage as OfflineMsg;
use Validator;

class GuestController extends Controller
{

    public function show_chat_widget(Request $request){
		$token = $request->token;
		return view('widgets/default/widget-init',compact('token'));	
	}	
	
	public function widget_content(Request $request){
		
		$url = $request->url;
		$token = $request->token;
		$company_id = helpdesk_decrypt($token);
				
		return view('widgets/default/widget',compact('token'));
	}
  
    public function store_guest_user(Request $request)
    {	
	    date_default_timezone_set(get_option('timezone'));
        $guest = new Guest();
	    $guest->name = $request->input('name');
		$guest->email = $request->input('email');
		$guest->mobile = $request->input('mobile') !="" ? $request->input('mobile') : '';
		$guest->department_id = $request->input('department') !="" ? $request->input('department') : 0;
        $guest->url = $request->input('url');
        $guest->ip = $_SERVER['REMOTE_ADDR'];
        $guest->profile_picture = "profile.png";
		$guest->last_activity = date("Y-m-d H:i:s");
		$guest->company_id = helpdesk_decrypt($request->input('vendor_token'));
        $guest->save();
		
		//Store Chat Request
		$chat_request = new ChatRequest();
		$chat_request->guest_id = $guest->id;
		$chat_request->operator_id = NULL;
		$chat_request->status = "chat_request";  //chat_request - chat_start - chat_end
		$chat_request->save();
		
		//Send Message
		$message = new Message();
	    $message->chat_request_id = $chat_request->id;
	    $message->message = $guest->name." "._lang('has started chat conversation');
	    $message->status = 0;
	    $message->sender = "guest";
	    $message->receiver = "operator";
	    $message->save();
		
		//Set Session
		$request->session()->put('guest_id', $guest->id);
		$request->session()->put('chat_request_id', $chat_request->id);
		$request->session()->put('guest_name', $guest->name);
        
		return redirect($_SERVER['HTTP_REFERER']);       
   }
   
   public function send_message(Request $request){
	   date_default_timezone_set(get_option('timezone'));
	   $message = new Message();
	   $message->chat_request_id = $request->session()->get('chat_request_id');
	   
	   //If message is an emoji
	   if(startsWith($request->message,"<img") || startsWith($request->message,"<a")){
		   $message->message = $request->message;
	   }else{
		   $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
		   $msg_string = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $request->message);
		   $message->message = $msg_string;
	   }
	   
	   $message->status = 0;
	   $message->sender = "guest";
	   $message->receiver = "operator";
	   $message->save();
	   echo "send";
   }
   
    public function get_messages(Request $request,$last_id=0){
	   \DB::beginTransaction();
	   $messages = Message::where("chat_request_id",$request->session()->get('chat_request_id'))
	                       ->where("id",">",$last_id)->get();
	
       $operator = \App\ChatRequest::join("users","chat_requests.operator_id","users.id")
	                               ->select("users.name")
                                   ->where("chat_requests.id",$request->session()->get('chat_request_id'))->first();	   
						   
	   echo json_encode(array("messages"=>$messages,"operator"=>$operator));
	   \DB::commit();
	}
	

	public function update_user_activity(Request $request){
		date_default_timezone_set(get_option('timezone'));

		if( $request->session()->get('guest_id') !="" ){	    		
			$guest_id = $request->session()->get('guest_id');
		    //$guest_name = $request->session()->get('guest_name');

			$chat_request = ChatRequest::find($request->session()->get('chat_request_id'));
			
			if($chat_request->status == "chat_end"){
				$request->session()->forget('guest_id');
				$request->session()->forget('chat_request_id');
				$request->session()->forget('guest_name');
				echo json_encode(array("status"=>"chat_end"));
			}else{	
				$chat_request->guest_is_typing = $request->typing;
				$chat_request->save();
				
				$guest = Guest::find($guest_id);
				$guest->last_activity = date("Y-m-d H:i:s");
				$guest->save();

				echo json_encode(array("status"=>"activity_updated","chat_request"=>$chat_request));
			}
		}
	}
	
	public function end_chat(Request $request){
	   date_default_timezone_set(get_option('timezone'));
	   $chat_request_id = $request->session()->get('chat_request_id');
	   $guest_name = $request->session()->get('guest_name');
	   
	   ChatRequest::where('id',$chat_request_id)->update(['status' => 'chat_end']);
	   $message = new Message();
	   $message->chat_request_id = $chat_request_id;
	   $message->message = "<span class='chat_ended'><i class='fa fa-sign-out'></i> ".$guest_name." "._lang('has ended chat session.')."</span>";
	   $message->status = 0;
	   $message->sender = "guest";
	   $message->receiver = "operator";
	   $message->save();
		
	   $request->session()->forget('guest_id');
	   $request->session()->forget('guest_name');
	   $request->session()->forget('chat_request_id');
	   echo $message->message;
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
	    $message->chat_request_id = $request->session()->get('chat_request_id');
	    $message->message = $msg_text;
	    $message->status = 0;
	    $message->sender = "guest";
	    $message->receiver = "operator";
	    $message->save();
		
		return response()->json(['result'=>'success','file'=>$file_name,'file_path'=>"/uploads/chat_files/$file_name",'message'=>'Uploaded Sucessfully']);
	    
	}
	
	
	public function send_offline_message(Request $request){
	    date_default_timezone_set(get_option('timezone'));
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);
		
		//Send Email
		$name = $request->input("name");
		$email = $request->input("email");
		$mobile = $request->input("mobile")!="" ? $request->input("mobile") : 'N/A';
		$subject = get_option('company_name')." Offline Message";
		$message = $request->input("message");
		
		//Save to database first
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required',
			'message' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->back()
				            ->withErrors($validator)
							->withInput();
			}			
		}

        $offlinemessage= new OfflineMsg();
	    $offlinemessage->name = $request->input('name');
		$offlinemessage->email = $request->input('email');
		$offlinemessage->mobile = $request->input('mobile');
		$offlinemessage->message = $request->input('message');
		$offlinemessage->company_id = helpdesk_decrypt($request->input('vendor_token'));
	
        $offlinemessage->save();
		
		
		/*$mail  = new \stdClass();
		$mail->name = $name;
		$mail->email = $email;
		$mail->mobile = $mobile;
		$mail->subject = $subject;
		$mail->message = $message;
		Mail::to(get_option('email'))->send(new OfflineMessage($mail));   
        */
		return redirect()->back()->with('success', _lang('Your Message Send Sucessfully'));	
	}
	
}
