@extends('layouts.guest')
@php
$local_url = url('locale');
@endphp
@section('content')
    <div class="row w-100 mx-0">
        <div class="col-12 col-lg-4 mx-auto">
            @if (Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    {{ Session::get('message') }}
                </div>
            @endif
            @if (Session::has('status'))
                <div class="alert alert-success alert-dismissable">
                    {{ Session::get('status') }}
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    {{ Session::get('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="sendpasswordresetlink">
                @csrf
                <div class="row align-items-center justify-content-center login-box login-gradient rounded p-3 p-md-5">
                    <div class="col-12 text-center login-logo">
                        <a href="https://app.example.com"><img src="{{ asset('assets/images/assets/example-logo-white.png') }}" class="img-fluid"
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
                        <h2 class="font-weight-bold text-white">{{ __('custom.forgot_password') }}</h2>
                    </div> --}}
                    <div class="col-12 text-center mt-5">
                        <div class="row">
                            <div class="col col-md-12">
                                <h3 class="font-weight-bold text-white">{{ __('custom.forgot_password') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <input id="email" type="email"
                            class="form-control grey-ph h-auto py-4 rounded-0 @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="{{ __('custom.email') }}">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 mt-3">
                        <button
                            class="btn bg-warning text-white py-4 font-weight-bold rounded-0 w-100  text-uppercase">{{ __('custom.forgot_password') }}
                            <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                                class="img-fluid ml-3 align-middle" alt=""></button>
                    </div>
                    <div class="col-12 mt-4">
                        <hr class="w-100 border border-white my-3" />
                    </div>
                    <div class="col-12 text-center mt-3">
                        <h4 class="text-light-pink">
                            <a href="https://app.example.com" class="text-white ml-2">{{ __('custom.Login') }}</a>&nbsp;&nbsp; | 
                            <a href="{{ route('register') }}"
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
    if ($("#sendpasswordresetlink").length > 0) {
        $("#sendpasswordresetlink").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
            },
            messages: {
                email: {
                    required: "{{trans('custom.email_is_required')}}",
                    email: "{{trans('custom.please_enter_valid_email')}}",
                },
            },
        })
    }
});
</script>
@endsection