<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use Validator;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $departments = Department::where("company_id",company_id())
								 ->orderBy("id","desc")->get();
        return view('backend.department.list',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.department.create');
		}else{
           return view('backend.department.modal.create');
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
			'department' => 'required|max:191',
			'description' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('departments/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			
	    
		
        $department= new Department();
	    $department->department = $request->input('department');
		$department->description = $request->input('description');
	    $department->company_id = company_id();
		
        $department->save();
        
		if(! $request->ajax()){
           return redirect('departments/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$department]);
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
        $department = Department::where("id",$id)->where("company_id",company_id())->first();
		if(! $request->ajax()){
		    return view('backend.department.view',compact('department','id'));
		}else{
			return view('backend.department.modal.view',compact('department','id'));
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
        $department = Department::where("id",$id)->where("company_id",company_id())->first();
		if(! $request->ajax()){
		   return view('backend.department.edit',compact('department','id'));
		}else{
           return view('backend.department.modal.edit',compact('department','id'));
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
		$validator = Validator::make($request->all(), [
			'department' => 'required|max:191',
			'description' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('departments.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $department = Department::where("id",$id)->where("company_id",company_id())->first();
		$department->department = $request->input('department');
		$department->description = $request->input('description');
		$department->company_id = company_id();
		
        $department->save();
		
		if(! $request->ajax()){
           return redirect('departments')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$department]);
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
        $department = Department::where("id",$id)->where("company_id",company_id());
        $department->delete();
        return redirect('departments')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
