@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Profile')}}
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered" width="100%">
					<tbody style="text-align: center;">
						<tr class="text-center">
							<td colspan="2"><img style="margin: auto;" class="thumb-image-lg thumbnail" src="{{ $profile->profile_picture != "" ? asset('uploads/profile/'.$profile->profile_picture) : '' }}"></td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Name') }}</td>
							<td>{{ $profile->name }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('User Type') }}</td>
							<td>{{ $profile->user_type }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Email') }}</td>
							<td>{{ $profile->email }}</td>
						</tr>
			
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection