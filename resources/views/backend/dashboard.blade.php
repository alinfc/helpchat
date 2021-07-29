@extends('layouts.app')

@section('content')
<div class="row">
  <!--Online User List-->
  <div class="col-md-4">
	  <!-- Panel 1 -->
	  <div class="col-md-12">
	     <ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="pill" href="#online_users">{{ _lang('Online Users') }}</a></li>
		  <li><a data-toggle="pill" href="#transfer_users">{{ _lang('Transfer Chat Users') }} <span id="transfer-request">0</span></a></li>
		</ul>
		
		<div class="tab-content">
			<div id="online_users" class="tab-pane fade in active"> 
				<div class="panel panel-default dashboard-panel">
					<div class="panel-body">
					   <ul class="online_user_list" id="online_user">

					   </ul>
					</div>
				</div>
			</div> 
			
			<div id="transfer_users" class="tab-pane fade"> 
				<div class="panel panel-default dashboard-panel">
					<div class="panel-body">
					   <ul class="online_user_list" id="transfer_user_list">

					   </ul>
					</div>
				</div>
			</div>
		</div><!--End Tab Content--> 
	  </div>
	  <!-- End Panel 1 -->
	  <!-- Panel 2 -->
	  <div class="col-md-12">
		 <div class="panel panel-primary dashboard-panel">
			<div class="panel-heading">{{ _lang('Online Operator') }}</div>
			<div class="panel-border-bottom"></div>
			<div class="panel-body">
			   <ul class="online_user_list" id="online_operator">

			   </ul>
			</div>
		 </div>
	  </div>
	  <!-- End Panel 2 -->
  </div>
  
  <!--Chat Window-->
  <div class="col-md-8">
     <div class="panel panel-default">
		<div class="panel-body default-border">
		   <!--new_message_head-->
		   <div class="chat">
		      <div class="chat-header clearfix">
				<img src="{{ asset('uploads/profile/profile.png') }}" alt="avatar">
				
				<div class="chat-about">
				  <div class="chat-with">{{ _lang('Chat with') }} <span id="guest_name">{{ _lang('...') }}</span></div>
				  <div class="chat-num-messages">{{ _lang('Guest URL') }}: <a href="" id="guest_url">{{ _lang('...') }}</a></div>
				</div>
				
				<div class="dropdown pull-right" id="chat_action" style="display:none;">
				  <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">{{ _lang('Chat Action') }}
				  <span class="caret"></span></button>
				  <ul class="dropdown-menu">
					<li><a class="ajax-modal" data-title="{{ _lang('Transfer Chat') }}" href="{{ url('chat/transfer_window') }}">{{ _lang('Transfer Chat') }}</a></li>
					<li><a href="#" class="end_chat_session">{{ _lang('End Chat') }}</a></li>
				  </ul>
				</div>
				
			  </div>
			  <div class="chat_area">
				    <ul class="chat-history">
					</ul>
					<p class="typing-status" style="display:none"><b>{{ _lang('typing') }} ...</b></p>
				</div>
		   </div>
		   <!--chat_area-->
		   <div class="message_write">
			  <div class="chat-input-box" contentEditable="true"></div>
			  <div class="clearfix"></div>
			  <div class="chat_buttons">
			     <a href="#" class="btn-send pull-left btn btn-success btn-sm">{{ _lang('Send') }}</a>
				 <input type="hidden" name="chat_request_id" id="chat_request_id">
				 <input type="hidden" name="guest_id" id="guest_id">
				 <input type="hidden" name="l_id" id="l_id">
				 @if(get_company_option("file_sharing") == "yes")
					<input type="file" name="file" id="file" style="display:none">
					<a href="#" class="btn-fileupload pull-right btn btn-info btn-sm"><i class="fa fa-cloud-upload" aria-hidden="true"></i> {{ _lang('Add File') }}</a>
				 @endif
			  </div>
		   </div>
		</div>
	 </div>
  </div>
</div>

@endsection
<div id="popover" class="pop-over"></div>
<audio id="chatSound">
  <source src="{{ asset('sounds/'.get_option('message_sound')) }}" type="audio/mpeg">
</audio>

@section('js-script')
<script>
$(window).load(function() {
   $(".chat_area").stop().animate({ scrollTop: $(".chat_area")[0].scrollHeight}, 500);
});
</script>
@endsection
