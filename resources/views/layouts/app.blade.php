<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
	  @if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
	     <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
	  @endif
	  <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ get_option('site_title','Helpdesk') }}</title>

      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" rel="stylesheet">
      <!-- Bootstrap -->
      <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
      <!-- Include roboto.css to use the Roboto web font, material.css to include the theme and ripples.css to style the ripple effect -->
      <link href="{{ asset('css/roboto.css') }}" rel="stylesheet">
      <link href="{{ asset('css/material.css') }}" rel="stylesheet">
      <link href="{{ asset('css/ripples.css') }}" rel="stylesheet">
      <link href="{{ asset('css/metisMenu.css') }}" rel="stylesheet">
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="{{ asset('css/datatables.css') }}" rel="stylesheet">
      <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
	  <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
	  <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
	  <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet">
	  <link href="{{ asset('css/summernote.css') }}" rel="stylesheet">
	  <link href="{{ asset('css/colorpicker.css') }}" media="screen"  rel="stylesheet">
	  <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
	  <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">
      @if(get_option('backend_direction') == "rtl")
	   <link href="{{ asset('css/RTL.css') }}" rel="stylesheet" />
	  @endif
	  <script type="text/javascript">
	   var direction = "{{ get_option('backend_direction') }}";
	   var _url = "{{ asset('/') }}";
	   var u_s = "{{ get_option('max_upload_size') }}";
	  </script>
   </head>
   <body>
	 <!-- Main Modal -->
	 <div id="main_modal" class="modal animated bounceInDown" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="modal-btn btn btn-danger btn-sm pull-right" data-dismiss="modal"><i class="glyphicon glyphicon-remove-circle"></i> {{ _lang('Exit') }}</button>
			<button type="button" id="modal-fullscreen" class="modal-btn btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-fullscreen"></i> {{ _lang('Full Screen') }}</button>
			<h5 class="modal-title"></h5>
		  </div>  
		  <div class="alert alert-danger" style="display:none; margin: 15px;"></div>
		  <div class="alert alert-success" style="display:none; margin: 15px;"></div>			  
		  <div class="modal-body" style="overflow:hidden;"></div>
		</div>

	  </div>
	 </div>
	
	 <div id="preloader">
		<div class="bar"></div>
	 </div>
	 
	 <!-- Start Main Wrapper -->  
	 <div id="main-wrapper">
		<!-- Start Content Area Section -->
		<section class="content-area">
		   <!-- Start Sidebar -->
		   <aside class="sidebar">
			  <!--User Profile -->
			  <div class="widget stay-on-collapse" id="widget-welcomebox">
				 <div class="widget-body welcome-box tabular">
					<div class="tabular-row">
					   <div class="tabular-cell welcome-avatar">
						  <a href="#"><img src="{{ Auth::user()->profile_picture != "" ? asset('uploads/profile/'.Auth::user()->profile_picture) :  asset('images/avatar.png') }}" class="avatar"></a>
					   </div>
					   <div class="tabular-cell welcome-options">
						  <span class="welcome-text">{{ _lang('Welcome') }},</span>
						  <a href="#" class="name">{{ Auth::user()->name }}</a>
					   </div>
					</div>
				 </div>
			  </div>
			  <div class="border-bottom"></div>
			  <!-- End User Profile -->
			  <nav class="sidebar-nav">
				 <ul class="metismenu" id="menu">
					<!--if User type is super admin -->
					@if(Auth::user()->user_type == "super_admin")
					<li><a href="{{ url('dashboard') }}" aria-expanded="false"><i class="mdi-hardware-desktop-mac"></i>&nbsp;<span class="menu-title">{{ _lang('Dashboard') }}</span></a></li>
					<li>
					   <a href="#" aria-expanded="false"><i class="mdi-action-assignment-ind"></i>&nbsp;<span class="menu-title">{{ _lang('Profile') }}</span> <span class="glyphicon arrow"></span></a>
					   <ul aria-expanded="false" class="collapse">
						  <li><a href="{{ url('profile/my_profile') }}">{{ _lang('View Profile') }}</a></li>
						  <li><a href="{{ url('profile/edit') }}">{{ _lang('Update Profile') }}</a></li>
						  <li><a href="{{ url('profile/change_password') }}">{{ _lang('Change Password') }}</a></li>
						  <li><a href="{{ url('logout') }}">{{ _lang('Logout') }}</a></li>
					   </ul>
					</li>
					<li>
					   <a href="#" aria-expanded="false"><i class="mdi-social-group"></i>&nbsp;<span class="menu-title">{{ _lang('Companies List') }}</span> <span class="glyphicon arrow"></span></a>
					   <ul aria-expanded="false" class="collapse">
						  <li><a href="{{ url('tenants') }}">{{ _lang('All Companies') }}</a></li>
						  <li><a href="{{ url('tenants/create') }}">{{ _lang('Add New') }}</a></li>
					   </ul>
					</li>
					<li><a href="{{ url('administration/general_settings') }}" aria-expanded="false"><i class="mdi-action-settings-applications"></i>&nbsp;<span class="menu-title">{{ _lang('Configurations') }}</span></a></li>					
					@else
						<li><a href="{{ url('dashboard') }}" aria-expanded="false"><i class="mdi-hardware-desktop-mac"></i>&nbsp;<span class="menu-title">{{ _lang('Dashboard') }}</span></a></li>
						<li>
						   <a href="#" aria-expanded="false"><i class="mdi-action-assignment-ind"></i>&nbsp;<span class="menu-title">{{ _lang('Profile') }}</span> <span class="glyphicon arrow"></span></a>
						   <ul aria-expanded="false" class="collapse">
							  <li><a href="{{ url('profile/my_profile') }}">{{ _lang('View Profile') }}</a></li>
							  <li><a href="{{ url('profile/edit') }}">{{ _lang('Update Profile') }}</a></li>
							  <li><a href="{{ url('profile/change_password') }}">{{ _lang('Change Password') }}</a></li>
							  <li><a href="{{ url('logout') }}">{{ _lang('Logout') }}</a></li>
						   </ul>
						</li>
					@endif
					
					
					<!--If User Type is admin-->
					@if(Auth::user()->user_type == "admin")
					
					@if(get_company_option('offline_mode','no') == "no")
						<li><a href="{{ url('administration/toggle_offline_mode') }}" aria-expanded="false"><i class="mdi-communication-dnd-on"></i>&nbsp;<span class="menu-title">{{ _lang('Enable Offline Mode') }}</span></a></li>
					@else
						<li style="background:#E91E63"><a href="{{ url('administration/toggle_offline_mode') }}" aria-expanded="false"><i style="color:#fff;"  class="mdi-communication-dnd-on"></i>&nbsp;<span style="color:#fff;" class="menu-title">{{ _lang('Disable Offline Mode') }}</span></a></li>
					@endif
					<li>
					   <a href="#" aria-expanded="false"><i class="mdi-hardware-phonelink"></i>&nbsp;<span class="menu-title">{{ _lang('Widget') }}</span> <span class="glyphicon arrow"></span></a>
					   <ul aria-expanded="false" class="collapse">
						  <li><a target="_blank" href="{{ url('widget_preview') }}">{{ _lang('Widget Preview') }}</a></li>
						  <li><a href="{{ url('widget_code') }}" data-title="{{ _lang('Widget Code') }}" class="ajax-modal">{{ _lang('Widget Code') }}</a></li>
					   </ul>
					</li>
					
				    <li>
					   <a href="#" aria-expanded="false"><i class="mdi-social-group"></i>&nbsp;<span class="menu-title">{{ _lang('User Management') }}</span> <span class="glyphicon arrow"></span></a>
					   <ul aria-expanded="false" class="collapse">
						  <li><a href="{{ url('users') }}">{{ _lang('All User') }}</a></li>
						  <li><a href="{{ url('users/create') }}">{{ _lang('Add New') }}</a></li>
					   </ul>
					</li>
					
					<li>
					   <a href="#" aria-expanded="false"><i class="mdi-hardware-phonelink"></i>&nbsp;<span class="menu-title">{{ _lang('Department') }}</span> <span class="glyphicon arrow"></span></a>
					   <ul aria-expanded="false" class="collapse">
						  <li><a href="{{ url('departments/create') }}">{{ _lang('Add Department') }}</a></li>
						  <li><a href="{{ url('departments') }}">{{ _lang('Department List') }}</a></li> 
					   </ul>
					</li>			
					
					<li><a href="{{ url('offline_messages') }}" aria-expanded="false"><i class="mdi-action-announcement"></i>&nbsp;<span class="menu-title">{!! _lang('Offline Messages').' '.offline_message_count() !!}</span></a></li>

					<li>
					   <a href="#" aria-expanded="false"><i class="mdi-action-settings-applications"></i>&nbsp;<span class="menu-title">{{ _lang('Configuration') }}</span> <span class="glyphicon arrow"></span></a>
					   <ul aria-expanded="false" class="collapse">
						  <li><a href="{{ url('administration/widget_settings') }}">{{ _lang('Widget Config') }}</a></li>
						  <li><a href="{{ url('message/chat_history') }}">{{ _lang('Chat History') }}</a></li>
					   </ul>
					</li>
					@endif
				 </ul>
			  </nav>
		   </aside>
		   <!-- End Sidebar -->
		   <!--Start Content -->
			 <section class="content"> 
			 	<!-- Start Header --> 
				<header class="admin-head">
				<div class="left-header">
					<div class="mini-nav">
						<div class="togglebutton">
							<label>
							<input type="checkbox" checked>
							</label>
						</div>
						<!--<i class="mdi-image-dehaze"></i>-->
					</div>
				</div>
				<div class="right-header">
					<div class="navbar custom-navbar navbar-right">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="top-right-menu dropdown-toggle" data-toggle="dropdown">
									<i class="mdi-maps-beenhere"></i>
									<span>{{ _lang('Hi').", ".Auth::user()->name }}</span>
									<b class="caret"></b>
								</a>
									<ul class="dropdown-menu">
										<li><a href="{{ url('profile/my_profile') }}">{{ _lang('Profile') }}</a></li>
										<li><a href="{{ url('profile/edit') }}">{{ _lang('Update Profile') }}</a></li>
										<li><a href="{{ url('profile/change_password') }}">{{ _lang('Change Password') }}</a></li>
										<li>
											<a class="dropdown-item" href="{{ route('logout') }}"
											onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">
											{{ _lang('Logout') }}
										</a>
									</li>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				</header>
				<!-- End Header -->
				<div class="page-title"><h2>{{ _lang('Dashboard') }}</h2></div>
				<div class="col-md-12" id="content-area"> 	 				
					@yield('content')
				</div>
			 </section>
		   <!-- End Content -->
		   <!-- Start Footer Section -->
		   <footer class="admin-footer">
			  <p>Developed By NFC Students &copy; 2021</p>
		   </footer>
		   <!-- End Footer -->
		</section>
		<!-- End Content Area Section -->
	 </div>
	 <!-- End Main Wrapper -->
	 <!-- END Site -->

	 <script src="{{ asset('js/jquery.min.js') }}"></script>
	 <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	 <script src="{{ asset('js/ripples.min.js') }}"></script>
	 <script src="{{ asset('js/material.min.js') }}"></script>
	 <script src="{{ asset('js/metisMenu.min.js') }}"></script>
	 <script src="{{ asset('js/datatables.min.js') }}"></script>
	 <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	 <script src="{{ asset('js/nicescroll.js') }}"></script>
	 <script src="{{ asset('js/moment.min.js') }}"></script>
	 <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
	 <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
	 <script src="{{ asset('js/select2.min.js') }}"></script>
	 <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
	 <script src="{{ asset('js/dropify.min.js') }}"></script>
	 <script src="{{ asset('js/toastr.js') }}"></script>
	 <script src="{{ asset('js/colorpicker.js') }}"></script>
	 <script src="{{ asset('js/print.js') }}"></script>
	 <script src="{{ asset('js/app.js') }}"></script>
	 <!-- JS -->
	@yield('js-script')
	 <script type="text/javascript">		
		$(document).ready(function() {
			// This command is used to initialize some elements and make them work properly
			$.material.init();
			
			@if(Request::is('dashboard'))
				 
			@else
				$(".page-title>h2").html($(".title").html()); 
				$(".page-title>h2").html($(".panel-title").html());
			@endif			
			
			$(".data-table").DataTable({
				responsive: true,
				"bAutoWidth":false,
				"ordering": false,
				"language": {
				   "decimal":        "",
				   "emptyTable":     "{{ _lang('No Data Found') }}",
				   "info":           "{{ _lang('Showing') }} _START_ {{ _lang('to') }} _END_ {{ _lang('of') }} _TOTAL_ {{ _lang('Entries') }}",
				   "infoEmpty":      "{{ _lang('Showing 0 To 0 Of 0 Entries') }}",
				   "infoFiltered":   "(filtered from _MAX_ total entries)",
				   "infoPostFix":    "",
				   "thousands":      ",",
				   "lengthMenu":     "{{ _lang('Show') }} _MENU_ {{ _lang('Entries') }}",
				   "loadingRecords": "{{ _lang('Loading...') }}",
				   "processing":     "{{ _lang('Processing...') }}",
				   "search":         "{{ _lang('Search') }}",
				   "zeroRecords":    "{{ _lang('No matching records found') }}",
				   "paginate": {
					  "first":      "{{ _lang('First') }}",
					  "last":       "{{ _lang('Last') }}",
					  "next":       "{{ _lang('Next') }}",
					  "previous":   "{{ _lang('Previous') }}"
				  },
				  "aria": {
					  "sortAscending":  ": activate to sort column ascending",
					  "sortDescending": ": activate to sort column descending"
				  }
			  },
			  dom: 'Blfrtip',
			  buttons: [
			  'copy', 'csv', 'excel', 'pdf', 'print'
			  ],
			});
			
			//Show Success Message
			@if(Session::has('success'))
			   Command: toastr["success"]("{{session('success')}}")
			@endif
			
			//Show Single Error Message
			@if(Session::has('error'))
			   Command: toastr["error"]("{{session('error')}}")
			@endif
			
			
			@php $i =0; @endphp

			@foreach ($errors->all() as $error)
				Command: toastr["error"]("{{ $error }}");
				
				var name= "{{$errors->keys()[$i] }}";
				
				$("input[name='"+name+"']").addClass('error');
				$("select[name='"+name+"'] + span").addClass('error');
				
				$("input[name='"+name+"'], select[name='"+name+"']").parent().append("<span class='v-error'>{{$error}}</span>");
				
				@php $i++; @endphp
			
			@endforeach
            
			updateUserActivity('{{ csrf_token() }}');
			
			setInterval(function(){ 
				updateUserActivity('{{ csrf_token() }}');
			}, {{ get_option('user_tracking_refresh_rate') }}000);
			
			setInterval(function(){ 
				updateMessage();
			}, {{ get_option('chatting_refresh_rate') }}000);
			
		});
	 </script>
   </body>
</html>