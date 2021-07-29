<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfflineMessage;
use Validator;
use Illuminate\Validation\Rule;

class OfflineMessageController extends Controller
{
	
	public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offlinemessages = OfflineMessage::where("company_id",company_id())
									     ->orderBy("id","desc")->get();
        return view('backend.offline_message.list',compact('offlinemessages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $offlinemessage = OfflineMessage::where("id",$id)->where("company_id",company_id())->first();
		$offlinemessage->status = 1;
		$offlinemessage->save();
		
		if(! $request->ajax()){
		    return view('backend.offline_message.view',compact('offlinemessage','id'));
		}else{
			return view('backend.offline_message.modal.view',compact('offlinemessage','id'));
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
        $offlinemessage = OfflineMessage::where("id",$id)->where("company_id",company_id());
        $offlinemessage->delete();
        return redirect('offline_messages')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
