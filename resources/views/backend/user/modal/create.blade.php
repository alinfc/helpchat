<form method="post" class="ajax-submit" autocomplete="off" action="{{route('users.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Name') }}</label>						
		<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Email') }}</label>						
		<input type="email" class="form-control" name="email" value="{{ old('email') }}">
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Password') }}</label>						
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
		<label class="control-label">{{ _lang('User Type') }}</label>						
		<select class="form-control" name="user_type" id="user-type" required>
		  <option value="operator">{{ _lang('Operator') }}</option>
		  <option value="admin">{{ _lang('Admin') }}</option>
		</select>
	  </div>
	</div>
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Department') }}</label>						
		<select class="form-control select2" id="department_id" name="department_id">
		  <option value="">{{ _lang('Select One') }}</option>
		  {{ create_option("departments","id","department") }}
		</select>
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

<script>
$("#user_type").val("{{ old('user_type') }}");
</script>