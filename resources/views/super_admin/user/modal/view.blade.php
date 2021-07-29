<div class="panel panel-default">
<div class="panel-body">
    <table class="table table-bordered">
		<tr><td colspan="2"><img style="margin: auto;" class="thumb-image-md thumbnail" src="{{ $company->user->profile_picture != "" ? asset('uploads/profile/'.$company->user->profile_picture) : '' }}"></td></tr>
		<tr><td>{{ _lang('Business Name') }}</td><td>{{ $company->business_name }}</td></tr>
		<tr><td>{{ _lang('Status') }}</td><td>{{ $company->status }}</td></tr>
		<tr><td>{{ _lang('Name') }}</td><td>{{ $company->user->name }}</td></tr>
		<tr><td>{{ _lang('Email') }}</td><td>{{ $company->user->email }}</td></tr>
    </table>
</div>
</div>
