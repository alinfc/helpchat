@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update User') }}</div>

			<div class="panel-body">
			<form method="post" class="ajax-submit" autocomplete="off" action="{{ action('SuperAdmin\TenantController@update', $id) }}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				
				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Business Name') }}</label>						
					<input type="text" class="form-control" name="business_name" value="{{ $company->business_name }}" required>
				  </div>
				</div>
				
				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Status') }}</label>						
					<select class="form-control" name="status" id="status" required>
					   <option value="active">{{ _lang('Active') }}</option>
					   <option value="inactive">{{ _lang('InActive') }}</option>
					   <option value="blocked">{{ _lang('Blocked') }}</option>
					</select>
				  </div>
				</div>
				
				<!--<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Valid To') }}</label>						
					<input type="text" class="form-control datepicker" name="valid_to" value="{{ $company->valid_to }}" required>
				  </div>
				</div>-->
				
				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Admin Name') }}</label>						
					<input type="text" class="form-control" name="name" value="{{ $company->user->name }}" required>
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Admin Email') }}</label>						
					<input type="email" class="form-control" name="email" value="{{ $company->user->email }}" required>
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Admin Password') }}</label>						
					<input type="password" class="form-control" name="password">
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Confirm Password') }}</label>						
					<input type="password" class="form-control" name="password_confirmation">
				 </div>
				</div>
				
				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Profile Picture') }} ( 300 X 300 {{ _lang('for better view') }} )</label>						
					<input type="file" class="dropify" name="profile_picture" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ $company->user->profile_picture != "" ? asset('uploads/profile/'.$company->user->profile_picture) : '' }}" >
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

@endsection

@section('js-script')
<script>
$("#status").val("{{ $company->status }}");
</script>
@endsection

