<div class="panel panel-default">
<div class="panel-body">
    <table class="table table-bordered">
		<tr><td colspan="2"><img style="margin: auto;" class="thumb-image-md thumbnail" src="{{ $user->profile_picture != "" ? asset('uploads/profile/'.$user->profile_picture) : '' }}"></td></tr>
		<tr><td>{{ _lang('Name') }}</td><td>{{ $user->name }}</td></tr>
		<tr><td>{{ _lang('Email') }}</td><td>{{ $user->email }}</td></tr>
		<tr><td>{{ _lang('User Type') }}</td><td>{{ ucwords($user->user_type) }}</td></tr>	
    </table>
</div>
</div>
