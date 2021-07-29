<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except('index');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(Auth::User()->user_type == 'super_admin'){
			$users = User::where('user_type','admin')
						 ->limit(10)
						 ->orderBy('id','desc')
						 ->get();
			return view('super_admin/dashboard',compact('users'));
		}else{
			return view('backend/dashboard');
		}
    }
	
	public function widget_preview()
    {
        return view('widgets/default/widget-preview');
    }
	
	public function widget_code()
    {
       return '<pre><textarea class="form-control" style="resize: none; text-align:center;" readOnly="true"><script src="'.url('chat_widget.js?token='.helpdesk_encrypt(company_id())).'"></script></textarea></pre>';
    }
	
}
