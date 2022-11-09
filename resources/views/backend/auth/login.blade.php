<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | Administrator Login</title>
    {{-- <link rel="shortcut icon" href="{{asset('new-customer/images/favicon.ico')}}" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">
</head>

<body class="gray-bg" style="background:url('{{ url('assets/images/assets/Register_Account/Group73.png') }}')">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div class="white-bg p-3" style="background-image: linear-gradient(to right, #cf62db , #3a1eb7);">
            <div class="mt-1">
                {{-- <h5 class="logo-name">{{env('APP_NAME')}}</h5> --}}
                {{-- <h3>{{env('APP_NAME')}}</h3> --}}
                <img src="{{asset('/assets/images/assets/Register_Account/Group83.png')}}" width="220">
            </div>
            <h3 class="mb-1 mt-1" style="color: #ffffff !important;">Administrator Login</h3>
            {{-- <p>Login in. To see it in action.</p> --}}
            <form method="POST" action='{{ route('admin.login') }}' aria-label="{{ __('Login') }}"
                autocomplete="off" class="m-t mt-40" id="adminloginform">
                @csrf
                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        autocomplete='off' placeholder="E-Mail Address" name="email" value="{{ old('email') }}"
                        autocomplete="email" autofocus>
                    @error('email')
                        <span class="help-block text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    @error('error')
                        <span class="help-block text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password" autocomplete='off'
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                        name="password" autocomplete="current-password">
                    @error('password')
                        <span class="help-block text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn bg-warning text-white block full-width m-b">Login</button>
            </form>

            <p class="m-t" style="color: #ffffff !important;"> <small><strong>Copyright</strong> {{ env('APP_NAME') }} &copy;
                    {{ date('Y') }}</small></p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('backend/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{asset('backend/js/plugins/validate/jquery.validate.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            if ($("#adminloginform").length > 0) {
                $("#adminloginform").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true,
                        },
                        password: {
                            required: true,
                        },
                    },
                    messages: {
                        email: {
                            required: "The email field is required.",
                            email: "Please enter valid email."
                        },
                        password: {
                            required: "The password field is required.",
                        },
                    },
                })
            }
        });
    </script>
</body>

</html>
