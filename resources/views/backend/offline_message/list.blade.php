@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Offline Message') }}</span></div>

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
				<th>{{ _lang('Mobile') }}</th>
				<th>{{ _lang('Message') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($offlinemessages as $offlinemessage)
			  <tr class="{{ $offlinemessage->status == 0 ? 'unread' : '' }}" id="row_{{ $offlinemessage->id }}">
				<td class='name'>{{ $offlinemessage->name }}</td>
				<td class='email'>{{ $offlinemessage->email }}</td>
				<td class='mobile'>{{ $offlinemessage->mobile }}</td>
				<td class='message'>{!! $offlinemessage->message !!}</td>
				<td>
				  <form action="{{action('OfflineMessageController@destroy', $offlinemessage['id'])}}" method="post">
					<a href="{{action('OfflineMessageController@show', $offlinemessage['id'])}}" data-title="{{ _lang('View Offline Message') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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


