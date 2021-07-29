<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Company;
use App\User;
use Validator;
use Auth;
use Hash;

class TenantController extends Controller
{

    public function __construct()
    {
        $this->middleware('super_admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = User::where('user_type','admin')
					 ->orderBy('id','desc')
					 ->get();
        return view('super_admin.user.list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('super_admin.user.create');
		}else{
           return view('super_admin.user.modal.create');
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
			'business_name' => 'required|max:191',
			'status' => 'required|max:20',
			//'valid_to' => 'required',
			'name' => 'required|max:191', //for user table
			'email' => 'required|email|unique:users|max:191',
			'password' => 'required|max:20|min:6|confirmed',
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
		
		//Create Company
		$company = new Company();
		$company->business_name = $request->input('business_name');
		$company->status = $request->input('status');
		$company->valid_to = date('Y-m-d');
		$company->save();
			
        $user = new User();
	    $user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->password = Hash::make($request->password);
		$user->user_type = 'admin';
		$user->company_id = $company->id;
	    if ($request->hasFile('profile_picture')){
           $image = $request->file('profile_picture');
           $file_name = "profile_".time().'.'.$image->getClientOriginalExtension();
           $image->move(base_path('public/uploads/profile/'),$file_name);
           $user->profile_picture = $file_name;
		}
        $user->save();
		
		//Set List data
		$company->status = ucwords($company->status);
		$company->valid_to = date('d/M/Y',strtotime($company->valid_to));
		$company->email = $user->email;
        
		if(! $request->ajax()){
           return redirect('users/create')->with('success', _lang('New tenant created sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('New tenant created sucessfully'),'data'=>$company]);
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
        $company = Company::find($id);
		if(! $request->ajax()){
		    return view('super_admin.user.view',compact('company','id'));
		}else{
			return view('super_admin.user.modal.view',compact('company','id'));
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
        $company = Company::find($id);
		if(! $request->ajax()){
		   return view('super_admin.user.edit',compact('company','id'));
		}else{
           return view('super_admin.user.modal.edit',compact('company','id'));
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
        $user = User::where("company_id",$id)->first();
		
		$validator = Validator::make($request->all(), [
			'business_name' => 'required|max:191',
			'status' => 'required|max:20',
			//'valid_to' => 'required',
			'name' => 'required|max:191',
			'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
			'password' => 'nullable|max:20|min:6|confirmed',
			'profile_picture' => 'nullable|image|max:5120',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('users.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
	    //Update Company
		$company = Company::find($id);
		$company->business_name = $request->input('business_name');
		$company->status = $request->input('status');
		$company->valid_to = date('Y-m-d');
		$company->save();
	
        //Update User
		$user->name = $request->input('name');
		$user->email = $request->input('email');
		if($request->password){
            $user->password = Hash::make($request->password);
        }
		$user->user_type = 'admin';
		if ($request->hasFile('profile_picture')){
           $image = $request->file('profile_picture');
           $file_name = "profile_".time().'.'.$image->getClientOriginalExtension();
           $image->move(base_path('public/uploads/profile/'),$file_name);
           $user->profile_picture = $file_name;
		}
        $user->save();
		
		//Set List data
		$company->status = ucwords($company->status);
		$company->valid_to = date('d/M/Y',strtotime($company->valid_to));
		$company->email = $user->email;
		
		if(! $request->ajax()){
           return redirect('users')->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Sucessfully'),'data'=>$company]);
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
		$company = Company::find($id);
        $company->delete();
		
        $user = User::where("company_id",$id);
        $user->delete();

        return redirect('tenants')->with('success',_lang('Removed Sucessfully'));
    }
	
}
