@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Update Profile') }}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<form action="{{ url('profile/update')}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post">
						@csrf
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Name') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="name" value="{{$profile->name}}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Email') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="email" value="{{ $profile->email }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Image (Square Size)') }} 200px X 200px</label>
							<div class="col-sm-9">
								<input type="file" class="form-control dropify" data-default-file="{{ $profile->profile_picture != "" ? asset('uploads/profile/'.$profile->profile_picture) : '' }}" name="profile_picture" data-allowed-formats="square" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-info">{{ _lang('Update Profile') }}</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection

