@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('Chat History') }}</span></div>

			<div class="panel-body">
			  <table id="history-table" class="table table-bordered">
				<thead>
				  <tr>
					<th>{{ _lang('Guest') }}</th>
					<th>{{ _lang('Email') }}</th>
					<th>{{ _lang('Mobile') }}</th>
					<th>{{ _lang('IP') }}</th>
					<th>{{ _lang('URL') }}</th>
					<th>{{ _lang('Operator') }}</th>
					<th>{{ _lang('Status') }}</th>
					<th class="text-center">{{ _lang('View Details') }}</th>
					<th class="text-center">{{ _lang('Delete') }}</th>
				  </tr>
				</thead>
				<tbody>
			
				</tbody>
			  </table>
		  
			</div>
		</div>
	</div>
</div>

@endsection

@section('js-script')
<script>
	$(function() {
        $('#history-table').DataTable({
            processing: true,
            serverSide: true,
			ajax: "{{ url('message/get_chat_history_data') }}",
			"columns" : [
					{ data : "guest.name", name : "guest.name" },
					{ data : "guest.email", name : "guest.email" },
					{ data : "guest.mobile", name : "guest.mobile" },
					{ data : "guest.ip", name : "guest.ip" },
					{ data : "guest.url", name : "guest.url" },
					{ data : "operator.name", name : "operator.name" },
					{ data : "status", name : "status" },
					{ data : "view", name : "view" },
					{ data : "delete", name : "delete" },
			],
			responsive: true,
			"bStateSave": true,
			"bAutoWidth":false,	
			"ordering": false
        });
    });
</script>
@endsection


