<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Setting;
use App\CompanySetting;
use Carbon\Carbon;
use DB;
use App\Utilities\PHPMySQLBackup;

class UtilityController extends Controller
{
    /**
     * Show the Settings Page.
     *
     * @return Response
     */

	public function __construct(){
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		
		$this->middleware('super_admin')->except('widget_settings','toggle_offline_mode');
		$this->middleware('admin')->only('widget_settings','toggle_offline_mode');
	} 
	 
    public function settings($store="",Request $request)
    {
		if($store == ""){
           return view('backend.administration.general_settings.settings');
        }else{	   
		    foreach($_POST as $key => $value){
				 if($key == "_token"){
					 continue;
				 }
				 
				 $data = array();
				 $data['value'] = $value; 
				 $data['updated_at'] = Carbon::now();
				 if(Setting::where('name', $key)->exists()){				
					Setting::where('name','=',$key)->update($data);			
				 }else{
					$data['name'] = $key; 
					$data['created_at'] = Carbon::now();
					Setting::insert($data); 
				 }
		    } //End Loop
			if(! $request->ajax()){
			   return redirect('administration/general_settings')->with('success', _lang('Saved sucessfully'));
			}else{
			   return response()->json(['result'=>'success','action'=>'update','message'=>_lang('Saved sucessfully')]);
			}
			//return redirect('administration/general_settings')->with('success',_lang('Saved Sucessfully'));
		}
	}
	
	
	public function widget_settings($store="",Request $request)
    {
		if($store == ""){
           return view('backend.administration.general_settings.widget_settings');
        }else{	   
		    foreach($_POST as $key => $value){
				 if($key == "_token"){
					 continue;
				 }
				 
				 $data = array();
				 $data['value'] = $value; 
				 $data['updated_at'] = Carbon::now();
				 $data['company_id'] = company_id();
				 if(CompanySetting::where('name', $key)->exists()){				
					CompanySetting::where('name','=',$key)->update($data);			
				 }else{
					$data['name'] = $key; 
					$data['created_at'] = Carbon::now();
					CompanySetting::insert($data); 
				 }
		    } //End Loop
			if(! $request->ajax()){
			   return redirect('administration/widget_settings')->with('success', _lang('Saved sucessfully'));
			}else{
			   return response()->json(['result'=>'success','action'=>'update','message'=>_lang('Saved sucessfully')]);
			}
		}
	}
	
	public function toggle_offline_mode(){
		$data = array();
		$data['name'] = "offline_mode";
		
		if(get_company_option('offline_mode','no') == "no"){
			$data['value'] = 'yes'; 
			$data['company_id'] = company_id();
			$data['updated_at'] = Carbon::now();
			if(CompanySetting::where('name', "offline_mode")->exists()){				
				CompanySetting::where('name','=',"offline_mode")->update($data);			
			}else{
				$data['value'] = 'yes'; 
			    $data['created_at'] = Carbon::now();
				CompanySetting::insert($data); 
			}
			
			return redirect()->back()->with('success', _lang('Offline mode enabled sucessfully'));
		}else{
			$data['value'] = 'no'; 
			$data['company_id'] = company_id();
			$data['updated_at'] = Carbon::now();
			if(CompanySetting::where('name', "offline_mode")->exists()){				
				CompanySetting::where('name','=',"offline_mode")->update($data);			
			}else{
				$data['value'] = 'no'; 
			    $data['created_at'] = Carbon::now();
				CompanySetting::insert($data); 
			}
			return redirect()->back()->with('success', _lang('Offline mode disabled sucessfully'));
		}
		
	}

	
	
	public function upload_logo(Request $request){
		$this->validate($request, [
			'logo' => 'required|image|mimes:jpeg,png,jpg|max:8192',
		]);

		if ($request->hasFile('logo')) {
			$image = $request->file('logo');
			$name = 'logo.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads');
			$image->move($destinationPath, $name);

			$data = array();
			$data['value'] = $name; 
			$data['updated_at'] = Carbon::now();
			
			if(Setting::where('name', "logo")->exists()){				
				Setting::where('name','=',"logo")->update($data);			
			}else{
				$data['name'] = "logo"; 
				$data['created_at'] = Carbon::now();
				Setting::insert($data); 
			}
			
			if(! $request->ajax()){
			   return redirect('administration/general_settings')->with('success', _lang('Saved sucessfully'));
			}else{
			   return response()->json(['result'=>'success','action'=>'update','message'=>_lang('Logo Upload successfully')]);
			}

		}
	}
	
}