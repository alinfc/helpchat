<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\User;
use Validator;
use Auth;
use Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except('update_user_activity');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where("company_id",company_id())
		             ->orderBy("id","desc")->get();
        return view('backend.user.list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.user.create');
		}else{
           return view('backend.user.modal.create');
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'email' => 'required|email|unique:users|max:191',
			'password' => 'required|max:20|min:6|confirmed',
			'user_type' => 'required',
			'department_id' => 'required_if:user_type,operator',
			'profile_picture' => 'nullable|image|max:5120',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('users/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			
        $user= new User();
	    $user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->password = Hash::make($request->password);
		$user->user_type = $request->input('user_type');
		$user->company_id = company_id();
		$user->department_id = $request->input('department_id');
	    if ($request->hasFile('profile_picture')){
           $image = $request->file('profile_picture');
           $file_name = "profile_".time().'.'.$image->getClientOriginalExtension();
           $image->move(base_path('public/uploads/profile/'),$file_name);
           $user->profile_picture = $file_name;
		}
        $user->save();
        
		if(! $request->ajax()){
           return redirect('users/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$user]);
		}
        
   }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $user = User::where("id",$id)->where("company_id",company_id())->first();
		if(! $request->ajax()){
		    return view('backend.user.view',compact('user','id'));
		}else{
			return view('backend.user.modal.view',compact('user','id'));
		} 
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $user = User::where("id",$id)->where("company_id",company_id())->first();
		if(! $request->ajax()){
		   return view('backend.user.edit',compact('user','id'));
		}else{
           return view('backend.user.modal.edit',compact('user','id'));
		}  
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$messages = [
			'department_id.required_if' => 'Operator needs to assign a department !',
		];
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
			'password' => 'nullable|max:20|min:6|confirmed',
			'user_type' => 'required',
			'department_id' => 'required_if:user_type,operator',
			'profile_picture' => 'nullable|image|max:5120',
		],$messages);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('users.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        $user = User::where("id",$id)->where("company_id",company_id())->first();
		$user->name = $request->input('name');
		$user->email = $request->input('email');
		if($request->password){
            $user->password = Hash::make($request->password);
        }
		$user->user_type = $request->input('user_type');
		$user->company_id = company_id();
	    $user->department_id = $request->input('department_id');
		if ($request->hasFile('profile_picture')){
           $image = $request->file('profile_picture');
           $file_name = "profile_".time().'.'.$image->getClientOriginalExtension();
           $image->move(base_path('public/uploads/profile/'),$file_name);
           $user->profile_picture = $file_name;
		}
        $user->save();
		
		if(! $request->ajax()){
           return redirect('users')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$user]);
		}
	    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where("id",$id)->where("company_id",company_id());
        $user->delete();
        return redirect('users')->with('success',_lang('Information has been deleted sucessfully'));
    }
	
	public function update_user_activity(Request $request){
		date_default_timezone_set(get_option('timezone'));
		$count_transfer_user = 0;
		
		$user = \App\User::find(Auth::User()->id);
		$user->last_activity = date("Y-m-d H:i:s");
		$user->save();
		
		//GET Operator Current Chat Request ID
		$chat_request_id = $request->session()->get('operator_chat_request_id');
		
		$online_users = array();
		
		//Show Online Operator
		$online_users['operator'] = "";
		$online_users['guest'] = "";
		$online_users['transfer_guest'] = "";
		foreach(online_operator() as $user){
			$online_users['operator'] .='<li class="active_operator"><a data-id="'.$user->id.'" data-email="'.$user->email.'" href="#">'.$user->name.'</a></li>';  
		}
		
		foreach(online_guest() as $guest){
			if($guest->id == NULL){
			   continue;
			}
			$operator ="";
			if($guest->operator !=""){
				$online_users['guest'] .='<li class="active_visitor"><a href="'.url('message/chat/'.$guest->chat_request_id).'" data-id="'.$guest->id.'" data-url="'.$guest->url.'" data-ip="'.$guest->ip.'" data-requestid="'.$guest->chat_request_id.'" data-name="'.$guest->name.'" data-operator="'.$guest->operator.'" data-email="'.$guest->email.'" data-mobile="'.$guest->mobile.'">'.$guest->name.' <span class="message_count">'.$guest->unread_message.'</span></a></li>';
			}else{
				$online_users['guest'] .='<li class="active_visitor guest_visitor"><a href="'.url('message/chat/'.$guest->chat_request_id).'" data-id="'.$guest->id.'" data-url="'.$guest->url.'" data-ip="'.$guest->ip.'" data-requestid="'.$guest->chat_request_id.'" data-name="'.$guest->name.'" data-operator="'.$guest->operator.'" data-email="'.$guest->email.'" data-mobile="'.$guest->mobile.'">'.$guest->name.' <span class="message_count">'.$guest->unread_message.'</span></a></li>';
		    }
			
			
			if($guest->chat_status == "chat_transfer" && $guest->operator_id == Auth::User()->id){
				$online_users['transfer_guest'] .='<li class="active_visitor transfer_visitor"><a href="'.url('message/chat/'.$guest->chat_request_id).'" data-id="'.$guest->id.'" data-url="'.$guest->url.'" data-ip="'.$guest->ip.'" data-requestid="'.$guest->chat_request_id.'" data-name="'.$guest->name.'" data-operator="'.$guest->operator.'" data-email="'.$guest->email.'" data-mobile="'.$guest->mobile.'">'.$guest->name.' <span class="message_count">'.$guest->unread_message.'</span></a></li>';
			    $count_transfer_user++;
			}
		}
		
		$chat_request = [];
		if($chat_request_id !=""){
			$chat_request = \App\ChatRequest::find($chat_request_id);
			$chat_request->operator_is_typing = $request->typing;
			$chat_request->save();
		}
		
		echo json_encode(
				array("online_users"=>$online_users,
			    "chat_request"=>$chat_request,
			    "count_transfer_user"=>$count_transfer_user)
			  );
	}
}
