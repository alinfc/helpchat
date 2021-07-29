$(document).ready(function () {
	//Set Sidebar Style
    if (typeof(Storage) !== "undefined") {
        if (localStorage.getItem("sidebar") == "responsive") {
            responsive_sidebar();
        } else {
            full_sidebar();
        }
    }
	
	//Dropdown
    $('.dropdown-toggle').dropdown();
	
	$('[data-toggle="tooltip"]').tooltip(); 

	//Init Navigation
    $('#menu').metisMenu();

    $(".mini-nav").click(function () {
        if ($(".sidebar").width() == 250) {
            responsive_sidebar();
            if (typeof(Storage) !== "undefined") {
                localStorage.setItem("sidebar", "responsive");
            }
        } else {
            full_sidebar();
            if (typeof(Storage) !== "undefined") {
                localStorage.setItem("sidebar", "full");
            }
        }

    });

	//Active menu
    $("#menu li a").each(function () {
        var path = window.location.href;
        if ($(this).attr("href") == path) {
            $("#menu li a").removeClass("active-menu");
            $(this).addClass("active-menu");
            $(this).parent().parent().addClass("in");
            $(this).parent().parent().attr("aria-expanded", true);
            $(this).parent().parent().prev().attr("aria-expanded", true);
            $(this).parent().parent().parent().addClass("active");
        }
    });


    function responsive_sidebar() {
        $(".menu-title").css("display", "none");
        $("#menu span").css("display", "none");
        $(".sidebar").animate({width: '60px'}, 500);
        $(".welcome-options").css("display", "none")
        $(".welcome-box").css("padding", "10px");
        $("#menu").css("padding-left", "7px");	
		$(".sidebar .welcome-box .welcome-avatar").css("width", "56px");	
		$(".sidebar .welcome-box .welcome-avatar img").css("width", "40px");
		$(".sidebar .welcome-box .welcome-avatar img").css("height", "40px");
		//Colse If Expand
        $("#menu li ul").css("display", "none");
		//content Animation
		if(direction != "rtl"){
			$(".content").animate({paddingLeft: '60px'}, 500);
        }else{
			$(".content").animate({paddingRight: '60px'}, 500);
		}
	}

    function full_sidebar() {
        $(".sidebar").animate({width: '250px'}, 300, function () {
            $(".menu-title").css("display", "inline");
            $("#menu span").css("display", "inline");
            $(".welcome-options").removeAttr("style");
            $("#menu li ul").removeAttr("style");
        });

        $(".welcome-box").removeAttr("style");
        $("#menu").css("padding-left", "0px");
		$(".sidebar .welcome-box .welcome-avatar").css("width", "75px");	
		$(".sidebar .welcome-box .welcome-avatar img").css("width", "60px");
		$(".sidebar .welcome-box .welcome-avatar img").css("height", "60px");
		//content Animation
		if(direction != "rtl"){
			$(".content").animate({paddingLeft: '250px'}, 300);
		}else{
			$(".content").animate({paddingRight: '250px'}, 300);
		}
    }


	//prevent menu Click
    $('#menu li').click(function () {
        if ($(".sidebar").width() == 60) {
            $("#menu").find("ul").css("display", "none");
			//$("#menu").find('li').has('ul').children('a').off('click');
        }
    });


	//Menu Hover Effect
    $('#menu li').hover(function () {
		if ($(".sidebar").width() == 60) {
			$(this).find("ul").removeAttr("style");
			$(this).find("ul").css("display", "block");
			$(this).find("ul").addClass("micro_menu");
		}
	},
	function () {
		if ($(".sidebar").width() == 60) {
			$(this).find("ul").css("display", "none");
			$(this).find("ul").removeClass("micro_menu");
		}
	});

	
	$(document).on('click','.btn-remove',function(){
		var c = confirm("Are you sure you want to permanently remove this record?");
	    if(c){
			return true;
		}
		return false;
	});
	
	$(".select2").select2(); 

	$(".datepicker").datepicker();
	
	$(".monthpicker").datepicker( {
		format: "mm/yyyy",
		viewMode: "months", 
		minViewMode: "months"
	});	

	$('.dropify').dropify();
	
	$('.datetimepicker').datetimepicker({
		format:'YYYY-MM-DD HH:mm:00'
	});
	
	$('.timepicker').datetimepicker({
		format:'HH:mm:00'
	});

	//Form validation
	validate();	

    /*Summernote editor*/
	if ($("#summernote,.summernote").length) {
		$('#summernote,.summernote').summernote({
			height: 200,
			dialogsInBody: true
		});
	}	
	
	$(".float-field").keypress(function(event) {
	   if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
			(event.which < 48 || event.which > 57)) { event.preventDefault();
		}
	});	

	$(".int-field").keypress(function(event) {
		if ((event.which < 48 || event.which > 57)) { event.preventDefault();
		}
	});	
	
	$(document).on('click','#modal-fullscreen',function(){
		$("#main_modal >.modal-dialog").toggleClass("fullscreen-modal");
	});
	
	//Mask Plugin
	$('.year').mask('0000-0000');
	
	$(".form-horizontal input:required, select:required, textarea:required").parent().prev().append("<span class='required'> *</span>");
	
	$("input:required, select:required, textarea:required").prev().append("<span class='required'> *</span>");
	
	$(".chat_ended").parent().addClass("end_session");
	
	$(document).on("click",".off-canvas-sidebar li a",function(){
		if ( $(this).has("ul")) {
			if(typeof $(this).parent().attr("class") == 'undefined'){
			   $(this).next().slideToggle(200);
			}
		}
	});
	
	//Print Command
	$(document).on('click','.print',function(){
		$("#preloader").css("display","block");
		var div = "#"+$(this).data("print");	
		$(div).print({
			timeout: 1000,
		});		
	});
	
	//Appsvan File Upload Field
	$(".appsvan-file").after("<input type='text' class='form-control filename' readOnly>"
	+"<button type='button' class='btn btn-info appsvan-upload-btn'>Browse</button>");
    
	$(".appsvan-file").each(function(){
		if($(this).data("value")){
			$(this).parent().find(".filename").val($(this).data("value"));
		}
		if($(this).attr("required")){
			$(this).parent().find(".filename").prop("required",true);
		}
	});
	
	$(document).on("click",".appsvan-upload-btn",function(){
		$(this).parent().find("input[type=file]").click();
	});
	
	$(document).on('change','.appsvan-file',function(){
		readFileURL(this);
	});

	function readFileURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {};
	
			$(input).parent().find(".filename").val(input.files[0].name);
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	//Ajax Modal Function
	$(document).on("click",".ajax-modal",function(){
		 var link = $(this).attr("href");
		 var title = $(this).data("title");
		 var fullscreen = $(this).data("fullscreen");
		 var elem = $(this);
		 $.ajax({
			 url: link,
			 beforeSend: function(){
				$("#preloader").css("display","block"); 
			 },success: function(data){
				$(elem).closest("tr").removeClass("unread");
				$("#preloader").css("display","none");
				$('#main_modal .modal-title').html(title);
				$('#main_modal .modal-body').html(data);
				$("#main_modal .alert-success").css("display","none");
				$("#main_modal .alert-danger").css("display","none");
				$('#main_modal').modal('show'); 
				
				if(fullscreen ==true){
					$("#main_modal >.modal-dialog").addClass("fullscreen-modal");
				}else{
					$("#main_modal >.modal-dialog").removeClass("fullscreen-modal");
				}
				
				//init Essention jQuery Library
				$("select.select2").select2();
				$('.year').mask('0000-0000');
				$(".ajax-submit").validate();
				$(".datepicker").datepicker();	
				$(".dropify").dropify();
				$("input:required, select:required, textarea:required").prev().append("<span class='required'> *</span>");
			 }
		 });
		 
		 return false;
	 }); 
	 
	 $("#main_modal").on('show.bs.modal', function () {
         $('#main_modal').css("overflow-y","hidden"); 		
     });
	 
	 $("#main_modal").on('shown.bs.modal', function () {
		setTimeout(function(){
		  $('#main_modal').css("overflow-y","auto");
		}, 1000);	
     });
	 
	 
	 //Ajax Modal Submit
	 $(document).on("submit",".ajax-submit",function(){			 
		 var link = $(this).attr("action");
		 $.ajax({
			 method: "POST",
			 url: link,
			 data:  new FormData(this),
			 mimeType:"multipart/form-data",
			 contentType: false,
			 cache: false,
			 processData:false,
			 beforeSend: function(){
				$("#preloader").css("display","block");  
			 },success: function(data){
				$("#preloader").css("display","none"); 
				var json = JSON.parse(data);
				if(json['result'] == "success"){
					$("#main_modal .alert-success").html(json['message']);
					$("#main_modal .alert-success").css("display","block");
					$("#main_modal .alert-danger").css("display","none");
					
					if(json['action'] == "update"){
						$('#row_'+json['data']['id']).find('td').each (function() {
						   if(typeof $(this).attr("class") != "undefined"){
							   $(this).html(json['data'][$(this).attr("class")]);
						   }
						});  
						
					}else if(json['action'] == "store"){
						$('.ajax-submit')[0].reset();
						//store = true;
						
						var new_row = $("table").find('tr:eq(1)').clone();
						
						$(new_row).attr("id", "row_"+json['data']['id']);
						
						$(new_row).find('td').each (function() {
						   if($(this).attr("class") == "dataTables_empty"){
							   window.location.reload();
						   }	
						   if(typeof $(this).attr("class") != "undefined"){
							   $(this).html(json['data'][$(this).attr("class")]);
						   }
						}); 
						
						var url  = window.location.href; 
						$(new_row).find('form').attr("action",url+"/"+json['data']['id']);
						$(new_row).find('.btn-warning').attr("href",url+"/"+json['data']['id']+"/edit");
						$(new_row).find('.btn-info').attr("href",url+"/"+json['data']['id']);
						
						$("table").prepend(new_row);
		
						//window.setTimeout(function(){window.location.reload()}, 2000);
					}
			    }else if(json['result'] == "error"){
					$("#main_modal .alert-danger").html(json['message']);
					$("#main_modal .alert-danger").css("display","block");
					$("#main_modal .alert-success").css("display","none");
							
				}else{
					jQuery.each( json['message'], function( i, val ) {
					   $("#main_modal .alert-danger").html("<p>"+val+"</p>");
					});
					$("#main_modal .alert-success").css("display","none");
					$("#main_modal .alert-danger").css("display","block");
				}
			 }
		 });

		 return false;
	 });
	 
	 //Ajax submit with validate
	 $(".appsvan-submit-validate").validate({
		 submitHandler: function(form) {
			 var elem = $(form);
			 $(elem).find("button[type=submit]").prop("disabled",true);
			 var link = $(form).attr("action");
			 $.ajax({
				 method: "POST",
				 url: link,
				 data:  new FormData(form),
				 mimeType:"multipart/form-data",
				 contentType: false,
				 cache: false,
				 processData:false,
				 beforeSend: function(){
				   button_val = $(elem).find("button[type=submit]").text();
				   $(elem).find("button[type=submit]").html('<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>');
				 
				 },success: function(data){
					$(elem).find("button[type=submit]").html(button_val);
					$(elem).find("button[type=submit]").attr("disabled",false);				
					var json = JSON.parse(data);
					if(json['result'] == "success"){
						Command: toastr["success"](json['message']);
					}else{
						jQuery.each( json['message'], function( i, val ) {
						   Command: toastr["error"](val);
						});
					}
				 }
			 });

			return false; 
		},invalidHandler: function(form, validator) {},
		  errorPlacement: function(error, element) {}
	 });
	 
	 //Ajax submit without validate
	 $(document).on("submit",".appsvan-submit",function(){		 
		 var elem = $(this);
		 $(elem).find("button[type=submit]").prop("disabled",true);
		 var link = $(this).attr("action");
		 $.ajax({
			 method: "POST",
			 url: link,
			 data:  new FormData(this),
			 mimeType:"multipart/form-data",
			 contentType: false,
			 cache: false,
			 processData:false,
			 beforeSend: function(){
			   button_val = $(elem).find("button[type=submit]").text();
			   $(elem).find("button[type=submit]").html('<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>');
			 
			 },success: function(data){
				$(elem).find("button[type=submit]").html(button_val);
				$(elem).find("button[type=submit]").attr("disabled",false);				
				var json = JSON.parse(data);
				if(json['result'] == "success"){
					Command: toastr["success"](json['message']);
				}else{
					jQuery.each( json['message'], function( i, val ) {
					   Command: toastr["error"](val);
					});
					
				}
			 }
		 });

		 return false;
	 });
	 
	
	
	//File Upload
	$(document).on('click','.btn-fileupload',function(){
		if($("#chat_request_id").val() != ""){
			$("#file").click();
		}
		return false;
	});
	
	$(document).on('change','#file',function(){	
		$(".btn-fileupload").prop("disabled",true);
		readChatFileURL(this);	
	});
	
	//Send Message
	$(document).on('click','.btn-send',function(){
		if($("#chat_request_id").val() != ""){
			$.ajax({
				method: "POST",
				url: _url+"message/send_message",
				data: {_token: $('meta[name="csrf-token"]').attr('content'), message: $(".chat-input-box").html(), chat_request_id: $("#chat_request_id").val()},
				success: function(data){
				  if(data == "send"){
					  send_message($(".chat-input-box").html());
				  }	
				}
			});
		}else{
			Command: toastr["error"]("No guest user selected !")
		}
		return false;
	});
	
	$(document).on('keypress','.chat-input-box',function(e){
		if(e.which == 13) {
			if($("#chat_request_id").val() != ""){
				$.ajax({
					method: "POST",
					url: _url+"message/send_message",
					data: {_token: $('meta[name="csrf-token"]').attr('content'), message: $(".chat-input-box").html(), chat_request_id: $("#chat_request_id").val()},
					success: function(data){
					  if(data == "send"){
						  send_message($(".chat-input-box").html());
					  }		
					},error: function(xhr, status, error) {
						console.log(xhr.responseText);
					}
				});
			}else{
				Command: toastr["error"]("No guest user selected !")
			}
			return false;
		}
	});
	
	$('.chat-input-box').keydown(function (e) {
	  if (e.ctrlKey && e.keyCode == 13) {
		 if($(".chat-input-box").html() == ''){
		     $(".chat-input-box").append('<div><br></div><br>').focusEnd();
		 }else{
			 $(".chat-input-box").append('<div><br></div>').focusEnd();
		 }
	  }
	});
	
	
	$(document).on('click','.canned_message a',function(){
		$(".chat-input-box").append($(this).data("message")).focusEnd();
		$(".dropup-content").fadeOut(100);
		return false;
	});
	
	//End Chat Session
	$(document).on("click",".end_chat_session",function(event){
		if($("#chat_request_id").val() != ""){
			var link = _url+"message/end_chat/"+$("#chat_request_id").val();
			//window.location = url
			$.ajax({
				method : "GET",
				url: link,
				success: function(data){
					send_message(data);
					$("#chat_action").fadeOut();
				}
			})
		}
		return false;
	});
	
	//Open Chat Window
	$(document).on('click','.active_visitor > a',function(){
		var elem = $(this);
		$("#chat_request_id").val($(elem).data("requestid"));
		$("#guest_id").val($(elem).data("id"));
		$("#guest_name").html($(elem).data("name"));
		$("#guest_url").attr("href",$(elem).data("url"));
		$("#guest_url").html($(elem).data("url"));
		
		$.ajax({
			method: "GET",
			url: $(elem).attr("href"),
			success: function(data){
				var html = '';
				var json = JSON.parse(data);
				if(json['access'] == "false"){
					Command: toastr["error"]("Sorry, This chat session has already an operator !");
					$("#chat_request_id").val("");
					$("#guest_id").val("");
					$("#guest_name").html("N/A");
					$("#guest_url").attr("href","#");
					$("#guest_url").html("N/A");
					return false;
				}
				if(json['messages'].length > 0){
					$.each(json['messages'], function(n, elem) {
						$("#l_id").val(elem["id"]);
						$("#chat_action").fadeIn();
						
						if(elem['sender'] == "guest"){
							html += '<li class="clearfix">'
								+'<div class="message-data align-right">'
								  +'<span class="message-data-time">'+moment(elem['created_at']).format('LLL')+'</span> &nbsp; &nbsp;'
								  +'<span class="message-data-name">'+$("#guest_name").html()+'</span> <i class="fa fa-circle me"></i>'
								  
								+'</div>'
								+'<div class="message other-message float-right">'
								  +elem['message']
								+'</div>'
							   +'</li>';
						}else{
							html += '<li>'
								+'<div class="message-data">'
								  +'<span class="message-data-name">'+$(".name").html()+'</span> <i class="fa fa-circle online"></i>'
								  +'<span class="message-data-time">'+moment(elem['created_at']).format('LLL')+'</span> &nbsp; &nbsp;'
  
								+'</div>'
								+'<div class="message my-message">'
								   +elem['message']
								+'</div>'
							   +'</li>';
						}							   
					});	
				}
				
				$(".chat-history").html(html);
				$(".chat_area").stop().animate({ scrollTop: $(".chat_area")[0].scrollHeight}, 500);
			}
		});
		return false;
	});
	
	$(document).on('mouseenter','.active_visitor > a',function(e){
	    $('#popover').css( 'position', 'absolute' );
		$('#popover').css( 'top', e.pageY);
		$('#popover').css( 'left', e.pageX);
		var html = '<table class="table table-bordered">'
		         +'<tr><td>Name</td><td>'+$(this).data("name")+'</td></tr>'
		         +'<tr><td>Email</td><td>'+$(this).data("email")+'</td></tr>'
		         +'<tr><td>Mobile</td><td>'+$(this).data("mobile")+'</td></tr>'
		         +'<tr><td>IP</td><td>'+$(this).data("ip")+'</td></tr>'
		         +'<tr><td>URL</td><td><a href="'+$(this).data("url")+'">'+$(this).data("url")+'</a></td></tr>'
		         +'<tr><td>Operator</td><td>'+$(this).data("operator")+'</td></tr>'
				 +'</table>';
		$('#popover').html(html);	
		$('#popover').show();
	});
	
	$(document).on('mouseleave','#popover',function(e){
		$('#popover').fadeOut(100);
	});	
	 

});

var is_typing = 0;

function readChatFileURL(input) {
	if (input.files && input.files[0]) {
		 if((input.files[0].size/1024) > (u_s*1024)){
			 Command: toastr["error"]("Maximum Fle Upload Size is "+parseFloat(u_s) * 1024+ "MB");
			 $(".btn-fileupload").attr("disabled",false);
			 return;
		 }
		 var link = _url+"/message/upload_file";
		 var form_data = new FormData();                  
		 form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		 form_data.append('file', input.files[0]);
		 $.ajax({
			 method: "POST",
			 url: link,
			 data:  form_data,
			 mimeType:"multipart/form-data",
			 contentType: false,
			 cache: false,
			 processData:false,
			 beforeSend: function(){
				button_val = $(".btn-fileupload").text();
				$(".btn-fileupload").html('<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>'); 
			 },success: function(data){
				var json =JSON.parse(data);
				if(json['result'] == "success"){
					
				  //Show Uploaded File
				  $(".chat-history").append('<li class="s_content">'
					+'<div class="message-data">'
					  +'<span class="message-data-name">'+$(".name").html()+'</span> <i class="fa fa-circle online"></i>'
					  +'<span class="message-data-time">'+moment().format('LLL')+'</span> &nbsp; &nbsp;'	  
					+'</div>'
					+'<div class="message my-message">'
					  +'<a target="_blank" href="'+json['file_path']+'">'+json['file']+'</a>'
					+'</div>'
				  +'</li>');
				  $(".chat_area").stop().animate({ scrollTop: $(".chat_area")[0].scrollHeight}, 500);
				}else{
				  //Show Error
				  Command: toastr["error"](json['message']);
				}
			 },complete: function (data) {  
				$(".btn-fileupload").html(button_val);
				$(".btn-fileupload").attr("disabled",false);
			 },error: function(xhr, status, error) {
				//console.log(xhr.responseText);
			 }
		 });
	}
}

function send_message(message){
	$(".chat-history").append('<li class="s_content">'
		+'<div class="message-data">'
		  +'<span class="message-data-name">'+$(".name").html()+'</span> <i class="fa fa-circle online"></i>'
		  +'<span class="message-data-time">'+moment().format('LLL')+'</span> &nbsp; &nbsp;'  
		+'</div>'
		+'<div class="message my-message">'
		  +message
		+'</div>'
	  +'</li>');
	$(".chat_area").stop().animate({ scrollTop: $(".chat_area")[0].scrollHeight}, 500);
	$(".chat-input-box").html("");
	//Typing status Change
	is_typing = 0;
}


function validate(){
	//Validation Form
	$(".validate").validate({
		submitHandler: function(form) {
			form.submit();
		},invalidHandler: function(form, validator) {},
		  errorPlacement: function(error, element) {}
	});
}


updateScreen = function (displayValue) {
    var displayValue = displayValue.toString();
    $('.screen').html(displayValue.substring(0, 10));
};

// Mechanism for typing status
$(".chat-input-box").keypress( function() {
   if($(this).html() !=""){
	  is_typing = 1; 
   }
});

$(".chat-input-box").blur( function() {
   //is_typing = 0;
});

updateUserActivity = function (token) {
    $.ajax({
		method:"POST",
		data: {_token: token,typing:is_typing},
		url:_url+"users/update_user_activity",
		success: function(data){
			var json = JSON.parse(data);
			var online_users = json['online_users'];
			$("#online_operator").html(online_users['operator']);
			$("#online_user").html(online_users['guest']);
			$("#transfer_user_list").html(online_users['transfer_guest']);
			$("#transfer-request").html(json['count_transfer_user']);
			
			if(parseInt(json['count_transfer_user']) > 0){
				$("#transfer-request").fadeIn();
			}else{
				$("#transfer-request").fadeOut();
			}
			
			var chat_request = json['chat_request'];
			var guest_is_typing = chat_request['guest_is_typing'];
			if(guest_is_typing == 1 && $("#chat_request_id").val() !=""){
				$(".typing-status").fadeIn();
				$(".chat_area").stop().animate({ scrollTop: $(".chat_area")[0].scrollHeight}, 500);	
			}else{
				$(".typing-status").fadeOut();
			}
			
			//Typing status Change
			is_typing = 0;
		}
	});
};

updateMessage = function () {
    if($("#chat_request_id").val() != "" && $("#chat_request_id").length){
		$.ajax({
			method: "GET",
			url: _url+"message/get_messages/"+$("#chat_request_id").val()+"/"+$("#l_id").val(),
			success: function(data){
				var html = '';
				var sound= false;
				var json = JSON.parse(data);
				if(json.length > 0){
					$.each(json, function(n, elem) {
						$("#l_id").val(elem["id"]);
						if(elem['sender'] == "guest"){
							sound = true;
							html += '<li class="clearfix">'
								+'<div class="message-data align-right">'
								  +'<span class="message-data-time">'+moment(elem['created_at']).format('LLL')+'</span> &nbsp; &nbsp;'
								  +'<span class="message-data-name">'+$("#guest_name").html()+'</span> <i class="fa fa-circle me"></i>'
								  
								+'</div>'
								+'<div class="message other-message float-right">'
								  +elem['message']
								+'</div>'
							   +'</li>';
						}else{
							html += '<li>'
								+'<div class="message-data">'
								  +'<span class="message-data-name">'+$(".name").html()+'</span> <i class="fa fa-circle online"></i>'
								  +'<span class="message-data-time">'+moment(elem['created_at']).format('LLL')+'</span> &nbsp; &nbsp;'
  
								+'</div>'
								+'<div class="message my-message">'
								   +elem['message']
								+'</div>'
							   +'</li>';
						}							   
					});
					                
                    $(".s_content").remove();
					$(".chat-history").append(html);
					$(".typing-status").fadeOut();
					if(sound == true){
						playSound();
					}
					$(".chat_area").stop().animate({ scrollTop: $(".chat_area")[0].scrollHeight}, 500);						
				}else{
				
					$(".s_content").remove();
					$(".chat-history").append(html);
					//$(".chat_area").stop().animate({ scrollTop: $(".chat_area")[0].scrollHeight}, 500);	
			    }
			}
		});
	}
};

isNumber = function (value) {
    return !isNaN(value);
}

playSound = function(){
	var sound = document.getElementById("chatSound"); 
	sound.play();
}

isOperator = function (value) {
    return value === '/' || value === '*' || value === '+' || value === '-';
};

operate = function (a, b, operation) {
    a = parseFloat(a);
    b = parseFloat(b);
    console.log(a, b, operation);
    if (operation === '+') return a + b;
    if (operation === '-') return a - b;
    if (operation === '*') return a * b;
    if (operation === '/') return a / b;
}

$.fn.focusEnd = function() {
    $(this).focus();
    var tmp = $('<span />').appendTo($(this)),
        node = tmp.get(0),
        range = null,
        sel = null;

    if (document.selection) {
        range = document.body.createTextRange();
        range.moveToElementText(node);
        range.select();
    } else if (window.getSelection) {
        range = document.createRange();
        range.selectNode(node);
        sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    }
    tmp.remove();
    return this;
}