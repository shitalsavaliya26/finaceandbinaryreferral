@extends('layouts.app')
@section('title', __('custom.register_user'))
@section('page_title', __('custom.register_user'))

@section('content')
    <div class="content-wrapper register-inner login-box">
        <div class="ml-2 mb-4 d-none-desk d-md-block">
      <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
      @if(Route::currentRouteName() == 'dashboard')
      <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
      @endif
    </div>
        <div class="row w-100 mx-0 mt-3 registerbox">
            <div class="col-12 mx-auto">
                <div class="row align-items-center login-gradient rounded py-4 p-md-5">
                    <!-- <div class="col-12 text-center">
                  <img src="images/assets/Register_Account/Group83.png" class="img-fluid" alt="logo">
                </div> -->
                    <!--  <div class="col-12 mt-5 text-white">
                  <h2 class="font-weight-bold">Register Account</h2>
                  <h5 class="text-light-pink">Enter the following to create your account</h5>
                </div> -->
       <!--          @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif -->
                    <div class="col-12">
                        <form method="post" action="{{ route('createmember') }}" class="customer-register py-5"
                            id="form-wizards-register">
                            @csrf
                            <h1 class="text-uppercase">{{ trans('custom.personal_detail') }}</h1>
                            <fieldset>
                                <div class="row justify-content-center mt-5">
                                    <div class="col-12 col-xl-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="text-white mb-2">{{ trans('custom.verify_sponsor_username') }}
                                                </h4>
                                            </div>
                                            <div
                                                class="col-12 col-lg-7 pr-lg-0 {{ $userName != '' ? 'cus-field-read' : '' }}">
                                                <input id="sponsor_username" type="text"
                                                    class="form-control grey-ph h-auto py-4 rounded-0 @error('sponsor_username') is-invalid @enderror"
                                                    name="sponsor_username" value="{{ $userName != '' ? $userName : '' }}"
                                                    autocomplete="sponsor_username" autofocus
                                                    placeholder="@lang('custom.sponsor_name_placeholder')"
                                                    {{ $userName != '' ? 'readonly' : '' }}>
                                                <input id="sponsor_check" type="hidden"
                                                    class="form-control grey-ph h-auto py-4 rounded-0 @error('sponsor_check') is-invalid @enderror"
                                                    name="sponsor_check" value="{{ $userName != '' ? $userName : '' }}"
                                                    autocomplete="sponsor_check" autofocus
                                                    placeholder="{{ trans('custom.sponsor_username') }}">
                                                <label
                                                    class="cus-error-sponsor">{{ trans('custom.sponsor_user_not_found_not__valid_sponsor') }}</label>
                                                <label class="cus-success-sponsor sucess"
                                                    style="display:{{ $userName != '' ? 'block' : 'none' }}">{{ trans('custom.sponsor_username_verified') }}</label>
                                                @error('sponsor_username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <label id="sponsor_username-error" class="error"
                                                    for="sponsor_username"></label>
                                            </div>
                                            <div class="col-12 col-lg-5 mt-2 mt-lg-0">
                                                <a href="javascript:void(0)"
                                                    class="btn bg-warning text-white py-4 font-weight-bold rounded-0 font-18 d-flex verify-sponser text-uppercase">{{ trans('custom.verify') }}
                                                    <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                                                        class="img-fluid ml-3 align-middle" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-6 mt-5 mt-xl-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="text-white mb-2">
                                                    {{ trans('custom.verify_placement_username') }}
                                                </h4>
                                            </div>
                                            <div class="col-12 col-lg-7 pr-lg-0">
                                                <input id="placement_username" type="text"
                                                    class="form-control grey-ph h-auto py-4 rounded-0 @error('placement_username') is-invalid @enderror"
                                                    id="placement_username" name="placement_username" value="{{ $placement != '' ? $placement : '' }}"
                                                    autocomplete="placement_username" autofocus
                                                    placeholder="@lang('custom.placement_name_placeholder')" {{ $placement != '' ? 'readonly' : '' }}>
                                                <input id="placement_check" type="hidden"
                                                    class="form-control grey-ph h-auto py-4 rounded-0 @error('placement_check') is-invalid @enderror"
                                                    name="placement_check" value="{{ $placement != '' ? $placement : '' }}" autocomplete="placement_check" autofocus
                                                    placeholder="{{ trans('custom.placement_username') }}">
                                                <label
                                                    class="cus-error-placement">{{ trans('custom.placement_user_not_found_not__valid_placement') }}</label>
                                                <label class="cus-success-placement sucess"
                                                    style="display:{{ $placement != '' ? 'block' : 'none' }}">{{ trans('custom.placement_username_verified') }}</label>
                                                @error('placement_username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <label id="placement_username-error" class="error"
                                                    for="placement_username"></label>
                                            </div>
                                            <div class="col-12 col-lg-5 mt-3 mt-lg-0">
                                                <a href="javascript:void(0)"
                                                    class="btn bg-warning text-white py-4 font-weight-bold rounded-0 font-18 d-flex text-uppercase verify-placement">{{ trans('custom.verify') }}
                                                    <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                                                        class="img-fluid ml-3 align-middle" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12 text-right leftright">
                                        <label class="cus-radio">
                                            <input class="d-none" type="radio" name="child_position" value="left"
                                                checked>
                                            <span class="text-uppercase">{{ trans('custom.left') }}</span>
                                        </label>
                                        <label class="cus-radio">
                                            <input class="d-none" type="radio" name="child_position" value="right">
                                            <span class="text-uppercase">{{ trans('custom.right') }}</span>
                                        </label>
                                    </div> -->

                                    <div class="col-12">
                                        <hr class="border border-white mt-4">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <h4 class="text-white">{{ trans('custom.personal_detail') }}</h4>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 pt-1 pr-md-0">
                                        <input id="fullname" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('fullname') is-invalid @enderror"
                                            name="fullname" value="{{ old('fullname') }}" autocomplete="fullname"
                                            autofocus placeholder="{{ trans('custom.full_name') }}">

                                        @error('fullname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 pt-1 pr-md-0 pl-md-2">
                                        <input id="username" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('username') is-invalid @enderror"
                                            name="username" value="{{ old('username') }}" autocomplete="username"
                                            autofocus placeholder="{{ trans('custom.username') }}">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 pt-1 pl-md-2">
                                        <input id="ic_number" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('ic_number') is-invalid @enderror"
                                            name="ic_number" value="{{ old('ic_number') }}" maxlength="12"
                                            autocomplete="ic_number" autofocus
                                            placeholder="{{ trans('custom.identification_number') }}" id="ic_number">

                                        @error('ic_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ic_number') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 pt-1 pr-md-0">
                                        <input id="phone_number" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('phone_number') is-invalid @enderror"
                                            name="phone_number" value="{{ old('phone_number') }}"
                                            autocomplete="phone_number" autofocus
                                            placeholder="{{ trans('custom.phone_number') }}">

                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-8 mt-2 pt-1 pl-md-2">
                                        <input id="address" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('address') is-invalid @enderror"
                                            name="address" value="{{ old('address') }}" autocomplete="address" autofocus
                                            placeholder="{{ trans('custom.address') }}">

                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 pt-1 pr-md-0">
                                        <input id="state" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('state') is-invalid @enderror"
                                            name="state" value="{{ old('state') }}" autocomplete="state" autofocus
                                            placeholder="{{ trans('custom.state') }}">

                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 pt-1 pr-md-0 pl-md-2">
                                        {{ Form::select('country', [null => trans('custom.select_country')] + $country, '', ['class' => 'form-control text-grey font-weight-bold h-auto py-4 rounded-0', 'id' => 'country_id']) }}
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 pt-1 pl-md-2">
                                        <input id="city" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('city') is-invalid @enderror"
                                            name="city" value="{{ old('city') }}" autocomplete="city" autofocus
                                            placeholder="{{ trans('custom.city') }}">

                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
                                        <input id="email" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                                            placeholder="{{ trans('custom.email') }}">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pl-md-2">
                                        <input id="confirm_email" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('confirm_email') is-invalid @enderror"
                                            name="confirm_email" value="{{ old('confirm_email') }}" id="confirm_email"
                                            autocomplete="confirm_email" autofocus
                                            placeholder="{{ trans('custom.repeat_email') }}">

                                        @error('confirm_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
                                        <input id="password" type="password"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('password') is-invalid @enderror"
                                            name="password" value="{{ old('password') }}" autocomplete="password"
                                            autofocus placeholder="{{ trans('custom.login_password') }}">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pl-md-2">
                                        <input id="password_confirmation" type="password"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" value="{{ old('password_confirmation') }}"
                                            autocomplete="password_confirmation" autofocus id="password_confirmation"
                                            placeholder="{{ trans('custom.repeat_password') }}">

                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
                                        <input id="secure_password" type="password"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('secure_password') is-invalid @enderror"
                                            name="secure_password" value="{{ old('secure_password') }}"
                                            autocomplete="secure_password" autofocus
                                            placeholder="{{ trans('custom.security_password') }}">

                                        @error('secure_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pl-md-2">
                                        <input id="confirm_secure_password" type="password"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('confirm_secure_password') is-invalid @enderror"
                                            name="confirm_secure_password" value="{{ old('confirm_secure_password') }}"
                                            id="confirm_secure_password" autocomplete="confirm_secure_password" autofocus
                                            placeholder="{{ trans('custom.repeat_security_password') }}">

                                        @error('confirm_secure_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>
                            <h1 class="text-uppercase">{{ trans('custom.BANK_DETAILS') }}</h1>
                            <fieldset>
                                <div class="row justify-content-center mt-5">
                                    <div class="col-12">
                                        <h4 class="text-white">{{ trans('custom.bank_details') }}</h4>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
                                        <input id="bank_name" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('bank_name') is-invalid @enderror"
                                            name="bank_name" value="{{ old('bank_name') }}" autocomplete="bank_name"
                                            autofocus placeholder="{{ trans('custom.name_of_bank') }}">

                                        @error('bank_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pl-md-2">
                                        <input readonly id="acc_holder_name" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('acc_holder_name') is-invalid @enderror"
                                            name="acc_holder_name" value="{{ old('acc_holder_name') }}"
                                            autocomplete="acc_holder_name" autofocus
                                            placeholder="{{ trans('custom.name_account_holder') }}">

                                        @error('acc_holder_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
                                        <input id="bank_branch" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('bank_branch') is-invalid @enderror"
                                            name="bank_branch" value="{{ old('bank_branch') }}"
                                            autocomplete="bank_branch" autofocus
                                            placeholder="{{ trans('custom.bank_branch_only') }}">

                                        @error('bank_branch')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pl-md-2">
                                        <input id="swift_code" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('swift_code') is-invalid @enderror"
                                            name="swift_code" value="{{ old('swift_code') }}" autocomplete="swift_code"
                                            autofocus placeholder="{{ trans('custom.swift_code') }}">

                                        @error('swift_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
                                        <input id="acc_number" type="text"
                                            class="form-control grey-ph h-auto py-4 rounded-0 @error('acc_number') is-invalid @enderror"
                                            name="acc_number" value="{{ old('acc_number') }}" autocomplete="acc_number"
                                            autofocus placeholder="{{ trans('custom.account_number') }}">

                                        @error('acc_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="bankc col-12 col-md-6 mt-2 pt-1 pl-md-2">
                                        {{ Form::select('bank_country_id', [null => trans('custom.select_bank_account_country')] + $country, '', ['class' => 'form-control text-grey font-weight-bold h-auto py-4 rounded-0']) }}
                                        @error('bank_country_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ asset('assets/js/custom/register.js') }}"></script>
        <script type="text/javascript">
        $( document ).ready(function() {
            $('#fullname').on('keypress keydown keyup',function(){
            var name = $(this).val();
            $('#acc_holder_name').val(name);
            });
        });
        </script>
    @endsection
