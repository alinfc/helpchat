<table class="table table-bordered">
  <thead>
    <th>{{ _lang('Operator Name') }}</th>
    <th>{{ _lang('Department') }}</th>
    <th>{{ _lang('Transfer') }}</th>
  </thead>
  <tbody>
    @foreach(online_operator() as $opearator)
	  @if($opearator->id == \Auth::User()->id)
	     @php continue; @endphp
      @endif
	  
		<tr>
		  <td>{{ $opearator->name }}</td>
		  <td>{{ $opearator->department }}</td>
		  <td><a href="{{ url('chat/transfer_chat') }}" data-id="{{ $opearator->id }}" class="btn btn-primary btn-sm transfer_chat">{{ _lang('Transfer') }}</a></td>
		</tr>  
	@endforeach
    
  </tbody>
</table>


<!--jQuery Code -->
<script>
$(document).on('click','.transfer_chat',function(){
	var request_id = $("#chat_request_id").val();
	var operator_id = $(this).data("id");
	var guest_id = $("#guest_id").val();
	var link = $(this).attr("href")+"/"+request_id+"/"+operator_id+"/"+guest_id;
	
	$.ajax({
		url: link,
		method: "GET",
		beforeSend: function(){
			$("#preloader").css("display","block");
		},success: function(data){
			$("#preloader").css("display","none");
			if(data == 'chat_transfer'){
				$("#chat_action").fadeOut();
				$("#chat_request_id").val("");
				$("#guest_id").val("");
				$("#guest_name").html("N/A");
				$("#guest_url").attr("href","#");
				$("#guest_url").html("N/A");
				$(".chat-history").html("");
				$('#main_modal').modal('hide');
				Command: toastr["success"]("{{ _lang('Chat Transfered Sucessfully') }}");   
			}
		}
	});
	return false;
});
</script>
