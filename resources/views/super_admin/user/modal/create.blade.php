<form method="post" class="ajax-submit" autocomplete="off" action="{{route('tenants.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Business Name') }}</label>						
		<input type="text" class="form-control" name="business_name" value="{{ old('business_name') }}" required>
	  </div>
	</div>
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Status') }}</label>						
		<select class="form-control" name="status" required>
		   <option value="active">{{ _lang('Active') }}</option>
		   <option value="inactive">{{ _lang('InActive') }}</option>
		   <option value="blocked">{{ _lang('Blocked') }}</option>
		</select>
	  </div>
	</div>
	
	<!--<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Valid To') }}</label>						
		<input type="text" class="form-control datepicker" name="valid_to" value="{{ old('valid_to') }}" required>
	  </div>
	</div>-->
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Admin Name') }}</label>						
		<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Admin Email') }}</label>						
		<input type="email" class="form-control" name="email" value="{{ old('email') }}">
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Admin Password') }}</label>						
		<input type="password" class="form-control" name="password">
	  </div>
	</div>
	
	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Confirm Password') }}</label>						
		<input type="password" class="form-control" name="password_confirmation" required>
	 </div>
	</div>
	
	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Profile Picture') }} ( 300 X 300 {{ _lang('for better view') }} )</label>						
		<input type="file" class="dropify" name="profile_picture" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="">
	 </div>
	</div>

				
	<div class="col-md-12">
	  <div class="form-group">
	    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
		<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
	  </div>
	</div>
</form>