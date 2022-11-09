@extends('layouts.guest')
@section('title', __('custom.sign_in'))
@php
$local_url = url('locale');
@endphp
<style>
    .g-recaptcha {
    transform:scale(0.87);
    transform-origin:0 0;
    transform: scaleX(1.15);
    }
    @media only screen and (max-width: 500px) {
    .g-recaptcha {
    transform:scale(0.70);
    transform-origin:0 0;
    }
    }
</style>
@section('content')
    <div class="row w-100 mx-0">
        <div class="col-12 col-lg-4 mx-auto">
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    {{ Session::get('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}" id="loginform">
                <div class="row align-items-center justify-content-center login-box login-gradient rounded p-3 p-md-5">
                    <div class="col-12 text-center login-logo">
                        <a href="https://example.com">
                        <img src="{{ asset('assets/images/assets/example-logo-white.png') }}" class="img-fluid"
                            alt="logo"></a>
                        <div class="navigation-cus">
                            <div class="cus-dropdown text-right mb-3 select-lang-de">
                                <select style=" height:35px;" class="form-control cus-bg-tra-b" data-width="fit"
                                    onchange="javascript:window.location.href='<?php echo $local_url; ?>/'+this.value;">
                                    <option <?php if(app()->getLocale() == 'en'){ echo 'selected' ;} ?> value="en"
                                        data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
                                    <option <?php if(app()->getLocale() == 'cn'){ echo 'selected' ;} ?> value="cn"
                                        data-content='<span class="flag-icon flag-icon-cn"></span> China'>中文(Chinese)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                   
                    {{-- <div class="col-12 text-center mt-5">
                        <h3 class="font-weight-bold text-white">{{ __('custom.welcome_text_desc') }}</h3>
                    </div> --}}
                    <div class="col-12 text-center mt-5">
                        <div class="row">
                            <div class="col col-md-12">
                                <h3 class="font-weight-bold text-white">{{ __('custom.welcome_text_desc') }}</h3>
                            </div>
                            
                        </div>
                    </div>
                    @csrf
                    <div class="col-12 mt-3">
                        <input id="username" type="username"
                            class="form-control grey-ph h-auto py-4 rounded-0 @error('username') is-invalid @enderror"
                             placeholder="{{ __('custom.username') }}" name="username" value="{{ old('username') }}"
                             autocomplete="username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 mt-3">
                        <input id="password" type="password"
                            class="form-control grey-ph h-auto py-4 rounded-0 @error('password') is-invalid @enderror"
                             placeholder="{{ __('custom.password') }}" name="password"
                            autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 mt-3">
                        {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display() !!}
                    </div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                            <strong style="color: #fff !important;text-align: center;font-size:80%;">{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                    <div class="col-12 mt-3">
                        <button type="submit"
                            class="btn bg-warning text-white py-4 font-weight-bold rounded-0 w-100 text-uppercase">{{ __('custom.sign_in') }}
                            <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                                class="img-fluid ml-3 align-middle" alt=""></button>
                    </div>
                    <div class="col-12 col-md-6 mt-3 text-white">
                        <label class="cus-checkbox d-flex">
                            <input class="d-none" type="checkbox">
                            <span></span>
                            <h4 class="ml-3 text-light-pink">{{ __('custom.remember_me') }}</h4>
                        </label>
                    </div>
                    <div class="col-12 col-md-6 mt-3 text-md-right">
                        @if (Route::has('password.request'))
                            <h4><a class="text-white"
                                    href="{{ route('password.request') }}">{{ __('custom.forgot_your_password') }}</a>
                            </h4>
                        @endif
                    </div>
                    <div class="col-12">
                        <hr class="w-100 border border-white my-3" />
                    </div>
                    <div class="col-12 text-center mt-4">
                        <h4 class="text-light-pink">{{ __('custom.not_amember') }}<a href="{{ route('register') }}"
                                class="text-white ml-2">{{ __('custom.sign_up') }}</a></h4>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')
<script type="text/javascript">
 
$( document ).ready(function() {
    if ($("#loginform").length > 0) {
        $("#loginform").validate({
            rules: {
                username: {
                    required: true,
                },
                password: {
                    required: true,
                },
            },
            messages: {
                username: {
                    required: "{{trans('custom.enter_username')}}",
                },
                password: {
                    required: "{{trans('custom.please_enter_password')}}",
                },
            },
            submitHandler: function(form) {
                if (grecaptcha.getResponse()) {
                    form.submit();
                } else {
                    swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: "{{trans('custom.please_confirm_captcha_to_proceed')}}",
                        footer: '<a href="">Why do I have this issue?</a>'
                    })
                }
            }
        })
    }
});

</script>   
@endsection
