<!DOCTYPE html>
<html>
<head>
	<title>{{env('APP_NAME')}} | Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <link rel="shortcut icon" href="{{asset('new-customer/images/favicon.ico')}}" /> --}}
	<link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('backend/css/lib/font-awesome5/css/all.min.css')}}" rel="stylesheet">
	<link href="{{asset('backend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('backend/css/style.css')}}" rel="stylesheet">
	
	<!-- Jasny css -->
	<link href="{{asset('backend/css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('backend/css/plugins/chosen/bootstrap-chosen.css')}}" rel="stylesheet">
	<!-- Magnific Popup css -->
	<link href="{{asset('backend/css/magnific-popup.css')}}" rel="stylesheet">
	<!-- Custom css -->
	{{-- <link href="{{ asset('backend/css/custom.css?v=1.0') }}" rel="stylesheet"> --}}
	<link href="{{ asset('backend/css/custom.css') . '?v=' . time() }}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		label.error {
			color: #cc5965;
			display: inline-block;
			margin-left: 5px;
			font-size: 12px;
		}
	</style>
	@yield('css')
</head>

<body class="cutomer-backend mini-navbar1 backend-theme">
	<div id="wrapper">	
		@include('layouts.backend.header')
		@include('layouts.backend.sidebar')
		<div id="page-wrapper" class="gray-bg">
			<!-- <div class="row border-bottom">
				
			</div> -->
			@if(Session::has('success'))
			<div class="alert alert-success" role="alert">
				<strong>Success!</strong> {{Session::get('success')}}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@endif
			@if(Session::has('error'))
			<div class="alert alert-danger" role="alert">
				<strong>Error!</strong> {{Session::get('error')}}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@endif
			@yield('content')
			<div class="footer">
				<div>
					<strong>Copyright</strong> {{env('APP_NAME')}} &copy; {{date('Y')}}
				</div>
			</div>
		</div>
	</div>
	@include('layouts.backend.foot')
	<script src="{{asset('backend/js/plugins/validate/jquery.validate.min.js')}}"></script>
	<script src="{{asset('backend/js/plugins/validate/additional-methods.min.js')}}"></script>
	<script src="{{asset('backend/js/plugins/validate/additional-methods.min.js')}}"></script>
	<!-- Magnific Popup -->
	<script src="{{asset('backend/js/jquery.magnific-popup.min.js')}}"></script>
	<!-- Chosen -->
	<script src="{{asset('backend/js/plugins/chosen/chosen.jquery.js')}}"></script>
	@yield('scripts')
	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': "{{csrf_token()}}"
			}
		});
		$( "input[name=start]" ).datepicker({
			changeMonth: true,
			changeYear: true,
			minDate: 0,
			onClose: function( selectedDate ) {
				$	( "input[name=end]" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "input[name=end]" ).datepicker({
			changeMonth: true,
			changeYear: true,
			minDate: 0,
			onClose: function( selectedDate ) {
				$( "input[name=start]" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	</script>
	<script src="{{asset('backend/js/custom.js')}}"></script>
</body>
</html>