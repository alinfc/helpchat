@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
		  <ul class="nav nav-tabs setting-tab">
			  <li class="active"><a data-toggle="tab" href="#general" aria-expanded="true">{{ _lang('General') }}</a></li>
			  <li class=""><a data-toggle="tab" href="#email" aria-expanded="false">{{ _lang('Email') }}</a></li>
			  <li class=""><a data-toggle="tab" href="#logo" aria-expanded="false">{{ _lang('Logo') }}</a></li>
		  </ul>
		  <div class="tab-content">
				
			  <div id="general" class="tab-pane fade in active">
				  <div class="panel panel-default">
				  <div class="panel-heading"><span class="panel-title">{{ _lang('Configurations') }}</span></div>

				  <div class="panel-body">
					  <form method="post" class="appsvan-submit params-panel" autocomplete="off" action="{{ url('administration/general_settings/update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Company Name') }}</label>						
							<input type="text" class="form-control" name="company_name" value="{{ get_option('company_name') }}" required>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Site Title') }}</label>						
							<input type="text" class="form-control" name="site_title" value="{{ get_option('site_title') }}" required>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Chatting Refresh Rate (Second)') }}</label>						
							<input type="text" class="form-control" name="chatting_refresh_rate" value="{{ get_option('chatting_refresh_rate') }}" required>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('User Tracking Refresh Rate (Second)') }}</label>						
							<input type="text" class="form-control" name="user_tracking_refresh_rate" value="{{ get_option('user_tracking_refresh_rate') }}" required>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Message Sound') }}</label>						
							<select class="form-control select2" name="message_sound" id="message_sound">
								{!! load_audio(get_option('message_sound')) !!}
							</select>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Maximum Upload Size MB') }}</label>						
							<input type="text" class="form-control" name="max_upload_size" value="{{ get_option('max_upload_size') }}" required>
						  </div>
						</div>

						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('File Type Supported') }}</label>						
							<input type="text" class="form-control" name="file_type_supported" value="{{ get_option('file_type_supported') }}" required>
						  </div>
						</div>
						
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Timezone') }}</label>						
							<select class="form-control select2" name="timezone" required>
							<option value="">{{ _lang('-- Select One --') }}</option>
							{{ create_timezone_option(get_option('timezone')) }}
							</select>
						  </div>
						</div>
						
						<div class="form-group">
						  <div class="col-md-12">
							<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
						  </div>
						</div>
					  </form>
				  </div>
				  </div>
			  </div>
			 
		
			  <div id="email" class="tab-pane fade">
				<div class="panel panel-default">
				  <div class="panel-heading"><span class="panel-title">{{ _lang('Email Settings') }}</span></div>
				  <div class="panel-body">
					<form method="post" class="appsvan-submit params-panel" autocomplete="off" action="{{ url('administration/general_settings/update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Mail Type') }}</label>						
							<select class="form-control niceselect wide" name="mail_type" id="mail_type" required>
							  <option value="mail" {{ get_option('mail_type')=="mail" ? "selected" : "" }}>{{ _lang('PHP Mail') }}</option>
							  <option value="smtp" {{ get_option('mail_type')=="smtp" ? "selected" : "" }}>{{ _lang('SMTP') }}</option>
							</select>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('From Email') }}</label>						
							<input type="text" class="form-control" name="from_email" value="{{ get_option('from_email') }}" required>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('From Name') }}</label>						
							<input type="text" class="form-control" name="from_name" value="{{ get_option('from_name') }}" required>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('SMTP Host') }}</label>						
							<input type="text" class="form-control smtp" name="smtp_host" value="{{ get_option('smtp_host') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('SMTP Port') }}</label>						
							<input type="text" class="form-control smtp" name="smtp_port" value="{{ get_option('smtp_port') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('SMTP Username') }}</label>						
							<input type="text" class="form-control smtp" autocomplete="off" name="smtp_username" value="{{ get_option('smtp_username') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('SMTP Password') }}</label>						
							<input type="password" class="form-control smtp" autocomplete="off" name="smtp_password" value="{{ get_option('smtp_password') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('SMTP Encryption') }}</label>						
							<select class="form-control smtp" name="smtp_encryption">
							   <option value="ssl" {{ get_option('smtp_encryption')=="ssl" ? "selected" : "" }}>{{ _lang('SSL') }}</option>
							   <option value="tls" {{ get_option('smtp_encryption')=="tls" ? "selected" : "" }}>{{ _lang('TLS') }}</option>
							</select>
						  </div>
						</div>
						
						<div class="form-group">
						  <div class="col-md-12">
							<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
						  </div>
						</div>		
					</form>
				   </div>
				 </div>
			  </div>
			  
			  <div id="logo" class="tab-pane fade">
			     <div class="panel panel-default">
				  <div class="panel-heading"><span class="panel-title">{{ _lang('Logo Upload') }}</span></div>
				    <div class="panel-body">
					   <form method="post" class="appsvan-submit params-panel" autocomplete="off" action="{{ url('administration/upload_logo') }}" enctype="multipart/form-data">				         
							
							{{ csrf_field() }}
							
							<div class="col-md-6 col-md-offset-3">
							  <div class="form-group">
								<label class="control-label">{{ _lang('Upload Logo') }}</label>						
								<input type="file" class="form-control dropify" name="logo" data-max-file-size="8M" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ get_logo() }}" required>
							  </div>
							</div>
							
							</br>
							<div class="form-group">
							  <div class="col-md-4 col-md-offset-4">
								<button type="submit" class="btn btn-primary btn-block">{{ _lang('Upload') }}</button>
							  </div>
							</div>	
							
					   </form>	
				   </div>
				 </div>
			  </div>
			  
		   </div>  
		</div>
	  </div>
     </div>
    </div>
@endsection

@section('js-script')
<script type="text/javascript">
if($("#mail_type").val() != "smtp"){
	$(".smtp").prop("disabled",true);
}
$(document).on("change","#mail_type",function(){
	if( $(this).val() != "smtp" ){
		$(".smtp").prop("disabled",true);
	}else{
		$(".smtp").prop("disabled",false);
	}
});

$(document).on("change","#message_sound",function(){
	var file = $(this).find(':selected').data("audio");
	var audio = document.createElement('audio');
	  audio.style.display = "none";
	  audio.src = "{{ asset('sounds') }}/"+file;
	  audio.autoplay = true;
	  audio.onended = function(){
	  audio.remove();
	};
    document.body.appendChild(audio);
	
});

</script>
@stop

