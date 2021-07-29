@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('Tenant List') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Tenant') }}" href="{{route('tenants.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			<table class="table table-bordered data-table">
			<thead>
				<th>{{ _lang('Name') }}</th>
				<th>{{ _lang('Email') }}</th>
				<th>{{ _lang('Status') }}</th>
				<th class="text-center">{{ _lang('Action') }}</th>
			</thead>
			<tbody>
			  
			  @foreach($users as $user)
			    <tr id="row_{{ $user->id }}">
					<td class='business_name'>{{ $user->company->business_name }}</td>
					<td class='email'>{{ $user->email }}</td>
					<td class='status'>{{ ucwords($user->company->status) }}</td>							
					<td class="text-center">
					  <form action="{{action('SuperAdmin\TenantController@destroy', $user->company->id)}}" method="post">
						<a href="{{action('SuperAdmin\TenantController@edit', $user->company->id)}}" data-title="{{ _lang('Update Tenant') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
						<a href="{{action('SuperAdmin\TenantController@show', $user->company->id)}}" data-title="{{ _lang('View Tenant') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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


