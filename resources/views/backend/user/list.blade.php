@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('User List') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add User') }}" href="{{route('users.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			<table class="table table-bordered data-table">
			<thead>
			  <tr>
				<th>{{ _lang('Name') }}</th>
				<th>{{ _lang('Email') }}</th>
				<th>{{ _lang('User Type') }}</th>
				<th>{{ _lang('Department') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($users as $user)
			    <tr id="row_{{ $user->id }}">
					<td class='name'>{{ $user->name }}</td>
					<td class='email'>{{ $user->email }}</td>
					<td class='user_type'>{{ ucwords($user->user_type) }}</td>					
					<td class='user_type'>{{ $user->department->department }}</td>					
					<td>
					  <form action="{{action('UserController@destroy', $user['id'])}}" method="post">
						<a href="{{action('UserController@edit', $user['id'])}}" data-title="{{ _lang('Update User') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
						<a href="{{action('UserController@show', $user['id'])}}" data-title="{{ _lang('View User') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="DELETE">
						<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
					  </form>
					</td>
			    </tr>
			  @endforeach
			</tbody>
		  </table>
			</div>
		</div>
	</div>
</div>

@endsection


