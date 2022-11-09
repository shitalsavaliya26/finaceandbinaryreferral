<!doctype html>
	<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Oops! Page expired| {{env('APP_NAME')}}</title>
		<link rel="stylesheet" href="{{ asset('assets/css/custom/feather.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/custom/themify-icons.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/css/dropify.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/customd.css').'?v='.time() }}">
		<style type="text/css">
			.content {
        
}
		</style>
		<!-- Jasny css -->
	</head>
	<body>
		<div class="container-scroller">
			<!-- loader Start -->
			<div id="loading">
				<div id="loading-center">
				</div>
			</div>
			<!-- loader END -->
			<!-- Wrapper Start -->
			<div class="wrapper">
				<div class="container-fluid p-0">
					<div class="row no-gutters">
						<div class="col-sm-12 text-center">
							<div class="iq-error content">
								<img src="" class="img-fluid iq-error-img" alt="">
								<h2 class="mt-5 mb-0 text-white">Your login is expired </h2>
								<!-- <a class="btn btn-primary mt-3" href="{{route('dashboard')}}"><i class="ri-home-4-line"></i>Back to Home</a>                             -->
								<a class="btn btn-primary mt-3" href="{{route('login')}}"><i class="ri-home-4-line"></i>Please click here to login </a>                            
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Wrapper END -->		
	</body>
	</html>