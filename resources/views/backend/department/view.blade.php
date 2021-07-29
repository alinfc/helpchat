@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Department') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Department') }}</td><td>{{ $department->department }}</td></tr>
			<tr><td>{{ _lang('Description') }}</td><td>{{ $department->description }}</td></tr>
			
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


