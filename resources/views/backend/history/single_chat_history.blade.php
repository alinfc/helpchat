@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Chat History') }}</div>

	<div class="panel-body">
	 <div class="chat">
	   <div class="chat_history_area">
		  <ul class="chat-history">
			  @foreach($chat_history as $chat)
			  
				  @if($chat->sender == "guest")
					  <li class="clearfix">
						<div class="message-data align-right">
						  <span class="message-data-time">{{ $chat->created_at }}</span> &nbsp; &nbsp;
						  <span class="message-data-name">{{ $chat->guest." ("._lang('Guest').")" }}</span> <i class="fa fa-circle me"></i>
						  
						</div>
						<div class="message other-message float-right">
						  {!! $chat->message !!}
						</div>
					  </li>
				  @else
					  <li>
						<div class="message-data">
						  <span class="message-data-name"><i class="fa fa-circle online"></i> {{ $chat->operator." ("._lang('Operator').")" }}</span>
						  <span class="message-data-time">{{ $chat->created_at }}</span>
						</div>
						<div class="message my-message">
						  {!! $chat->message !!}
						</div>
					  </li>
				  @endif
              @endforeach
			</ul>
		</div>
	  </div>	
	</div>
  </div>
 </div>
</div>
@endsection


