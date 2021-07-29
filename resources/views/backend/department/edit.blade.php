@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Department') }}</div>

			<div class="panel-body">
			 <div class="col-md-6">
				 <form method="post" class="validate" autocomplete="off" action="{{action('DepartmentController@update', $id)}}" enctype="multipart/form-data">
					{{ csrf_field()}}
					<input name="_method" type="hidden" value="PATCH">				
					
					<div class="col-md-12">
					 <div class="form-group">
						<label class="control-label">{{ _lang('Department') }}</label>						
						<input type="text" class="form-control" name="department" value="{{ $department->department }}" required>
					 </div>
					</div>

					<div class="col-md-12">
					 <div class="form-group">
						<label class="control-label">{{ _lang('Description') }}</label>						
						<textarea class="form-control" name="description">{{ $department->description }}</textarea>
					 </div>
					</div>

					
					<div class="form-group">
					  <div class="col-md-12">
						<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
					  </div>
					</div>
				 </form>
			   </div> 
			</div>
		</div>
	</div>
</div>

@endsection


