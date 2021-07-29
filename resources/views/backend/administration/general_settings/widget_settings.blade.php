@extends('layouts.app')
@section('content')
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
			<span class="panel-title">{{ _lang('Widget Settings') }}</span>
		    <a href="{{ url('widget_preview') }}" target="_blank" class="btn btn-info btn-sm pull-right">{{ _lang('Preview Widget') }}</a>
		 </div>
         <div class="panel-body">
            <form method="post" class="validate params-panel" autocomplete="off" action="{{ url('administration/widget_settings/update') }}" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">{{ _lang('Primary Color') }}</label>						
                     <input type="text" class="form-control c-picker" name="primary_color" value="{{ get_company_option('primary_color') }}" required>
                  </div>
               </div>
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">{{ _lang('Secondary Color') }}</label>						
                     <input type="text" class="form-control c-picker" name="secondary_color" value="{{ get_company_option('secondary_color') }}" required>
                  </div>
               </div>
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">{{ _lang('Label Color') }}</label>						
                     <input type="text" class="form-control c-picker" name="label_color" value="{{ get_company_option('label_color') }}" required>
                  </div>
               </div>
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">{{ _lang('Heading Text') }}</label>						
                     <input type="text" class="form-control" name="heading_text" value="{{ get_company_option('heading_text') }}" required>
                  </div>
               </div>
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">{{ _lang('Offline Alert text') }}</label>						
                     <input type="text" class="form-control" name="offline_text" value="{{ get_company_option('offline_text') }}" required>
                  </div>
               </div>
			   
			   <div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Email') }}</label>						
					<input type="text" class="form-control" name="email" value="{{ get_company_option('email') }}" required>
				  </div>
				</div>
			   			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">{{ _lang('Widget Direction') }}</label>						
                     <select class="form-control select2" name="widget_direction" required>
                        <option value="right" {{ get_company_option('widget_direction')=="right" ? "selected" : "" }}>{{ _lang('Right') }}</option>
                        <option value="left" {{ get_company_option('widget_direction')=="left" ? "selected" : "" }}>{{ _lang('Left') }}</option>
					 </select>
				  </div>
               </div>
			   
			   <div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Allow file Sharing') }}</label>						
					<select class="form-control select2" name="file_sharing" required>
						<option value="yes" {{ get_company_option('file_sharing') == "yes" ? 'selected' : '' }}>{{ _lang('Yes') }}</option>
						<option value="no" {{ get_company_option('file_sharing') == "no" ? 'selected' : '' }}>{{ _lang('No') }}</option>
					</select>
				  </div>
				</div>
				
				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Enable Department') }}</label>						
					<select class="form-control select2" name="allow_department" required>
						<option value="yes" {{ get_company_option('allow_department') == "yes" ? 'selected' : '' }}>{{ _lang('Yes') }}</option>
						<option value="no" {{ get_company_option('allow_department') == "no" ? 'selected' : '' }}>{{ _lang('No') }}</option>
					</select>
				  </div>
				</div>				
			   	   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">{{ _lang('Mobile version breakpoint in pixels') }}</label>						
                     <input type="text" class="form-control" name="mobile_version_breakpoint" value="{{ get_company_option('mobile_version_breakpoint') }}" required>
                  </div>
               </div>
			   
			   <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">{{ _lang('Enable Mobile Field') }}</label>						
                     <select class="form-control select2" name="mobile_field" required>
                        <option value="no" {{ get_company_option('mobile_field')=="no" ? "selected" : "" }}>{{ _lang('No') }}</option>
						<option value="yes" {{ get_company_option('mobile_field')=="yes" ? "selected" : "" }}>{{ _lang('Yes') }}</option>
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
</div>
</div>
</div>
</div>
@endsection

@section('js-script')
<script>
$('.c-picker').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		$(el).val("#"+hex);
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
	}
}).bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});
</script>
@endsection