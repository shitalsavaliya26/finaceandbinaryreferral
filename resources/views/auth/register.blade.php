@php
use App\Models\Country;
$country = Country::pluck('country_name','id')->toArray();
$userName = \Request::segment(2);

$local_url = url('locale');
@endphp
@extends('layouts.guest')
@section('content')
<style>
    ul li {
        list-style:disc
    }
    li {
        margin-left:20px
    }
</style>
<div class="row w-100 mx-0 registerbox">
  <div class="col-12 col-lg-8 mx-auto">
     <div class="row align-items-center login-gradient login-box rounded py-4 p-md-5">
        <div class="col-12 text-center login-logo">
            <a href="https://app.example.com"><img src="{{ asset('assets/images/assets/example-logo-white.png') }}" class="img-fluid" alt="logo"></a>
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
         
        {{-- <div class="col-12 mt-5 text-white">
            <h2 class="font-weight-bold">@lang('custom.register_account')</h2>
            <h5 class="text-light-pink">{{ __('custom.sign_up_desc') }}</h5>
        </div> --}}
        <div class="col-12 mt-5 text-center text-white">
            <div class="row">
                <div class="col col-md-12">
                    <h2 class="font-weight-bold">@lang('custom.register_account')</h2>
                    <h5 class="text-light-pink">{{ __('custom.sign_up_desc') }}</h5>
                </div>
                
            </div>
        </div>

        <div class="col-12">
           <form method="post" action="{{ route('register') }}" class="customer-register py-4" id="form-wizards-register">
            @csrf
            <h1>{{trans('custom.personal_detail')}}</h1>
            <fieldset>
                <div class="row justify-content-center mt-5">
                   <div class="col-12 col-xl-6">
                      <div class="row">
                         <div class="col-12">
                            <h4 class="text-white">{{trans('custom.verify_sponsor_username')}}</h4>
                        </div>
                        <div class="col-12 col-lg-7 pr-lg-0">
                         <input id="sponsor_username" type="text"
                         class="form-control grey-ph h-auto py-4 rounded-0 @error('sponsor_username') is-invalid @enderror" name="sponsor_username"
                         value="{{($userName != '') ? $userName : ''}}" autocomplete="sponsor_username" autofocus
                         placeholder="@lang('custom.sponsor_name_placeholder')"
                         {{($userName != '') ? 'readonly' : ''}}>
                         <input id="sponsor_check" type="hidden"
                         class="form-control grey-ph h-auto py-4 rounded-0 @error('sponsor_check') is-invalid @enderror" name="sponsor_check"
                         value="" autocomplete="sponsor_check" autofocus
                         placeholder="{{trans('custom.sponsor_username')}}">
                         <label
                         class="cus-error-sponsor">{{trans('custom.sponsor_user_not_found_not__valid_sponsor')}}</label>
                         <label class="cus-success-sponsor sucess"
                         style="display:none">{{trans('custom.sponsor_username_verified')}}</label>
                         @error('sponsor_username')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                         @enderror
                         <label id="sponsor_username-error" class="error" for="sponsor_username"></label>
                     </div>
                     <div class="col-12 col-lg-5 mt-2 mt-lg-0">
                        <a href="javascript:void(0)" class="btn bg-warning text-white py-4 font-weight-bold rounded-0 font-18 d-flex verify-sponser text-uppercase">{{trans('custom.verify')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-3 align-middle" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6 mt-5 mt-xl-0">
                <div class="row">
                   <div class="col-12">
                      <h4 class="text-white">{{trans('custom.verify_placement_username')}}</h4>
                  </div>
                  <div class="col-12 col-lg-7 pr-lg-0">
                    <input id="placement_username" type="text"
                    class="form-control grey-ph h-auto py-4 rounded-0 @error('placement_username') is-invalid @enderror" id="placement_username" name="placement_username"
                    value="{{($userName != '') ? $userName : ''}}" autocomplete="placement_username" autofocus
                    placeholder="@lang('custom.placement_name_placeholder')"
                    {{($userName != '') ? 'readonly' : ''}}>
                    <input id="placement_check" type="hidden"
                    class="form-control grey-ph h-auto py-4 rounded-0 @error('placement_check') is-invalid @enderror" name="placement_check"
                    value="{{($userName != '') ? $userName : ''}}" autocomplete="placement_check" autofocus
                    placeholder="{{trans('custom.placement_username')}}">
                    <label
                    class="cus-error-placement">{{trans('custom.placement_user_not_found_not__valid_placement')}}</label>
                    <label class="cus-success-placement sucess"
                    style="display:{{($userName != '') ? 'block' : 'none'}}">{{trans('custom.placement_username_verified')}}</label>
                    @error('placement_username')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                   </span>
                   @enderror
                   <label id="placement_username-error" class="error" for="placement_username"></label>
               </div>
               <div class="col-12 col-lg-5 mt-3 mt-lg-0">
                <a href="javascript:void(0)"  class="btn bg-warning text-white py-4 font-weight-bold rounded-0 font-18 d-flex text-uppercase verify-placement">{{trans('custom.verify')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-3 align-middle" alt=""></a>
            </div>
        </div>
    </div>
    <!-- <div class="col-12 text-right leftright">
       <label class="cus-radio">
          <input class="d-none" type="radio" name="child_position" value="left" checked>
          <span class="text-uppercase">{{trans('custom.left') }}</span>
      </label>
      <label class="cus-radio">
          <input class="d-none" type="radio" name="child_position" value="right">
          <span class="text-uppercase">{{trans('custom.right') }}</span>
      </label>
  </div> -->

  <div class="col-12">
   <hr class="border border-white mt-4">
</div>
<div class="col-12 mt-4">
   <h4 class="text-white">{{trans('custom.personal_detail')}}</h4>
</div>
<div class="col-12 col-md-4 mt-2 pt-1 pr-md-0">
    <input id="fullname" type="text" class="form-control grey-ph h-auto py-4 rounded-0 @error('fullname') is-invalid @enderror"
    name="fullname" value="{{ old('fullname') }}" autocomplete="fullname" autofocus
    placeholder="{{trans('custom.full_name')}}">

    @error('fullname')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>

<div class="col-12 col-md-4 mt-2 pt-1 pr-md-0 pl-md-2">
   <input id="username" type="text" class="form-control grey-ph h-auto py-4 rounded-0 @error('username') is-invalid @enderror"
   name="username" value="{{ old('username') }}" autocomplete="username" autofocus
   placeholder="{{trans('custom.username')}}">

   @error('username')
   <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
   </span>
   @enderror
</div>
<div class="col-12 col-md-4 mt-2 pt-1 pl-md-2">
    <input id="ic_number" type="text" class="form-control grey-ph h-auto py-4 rounded-0 @error('ic_number') is-invalid @enderror" name="ic_number" value="{{ old('ic_number') }}" maxlength="12" autocomplete="ic_number" autofocus
    placeholder="{{trans('custom.identification_number')}}" id="ic_number">

    @error('ic_number')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $errors->first('ic_number') }}</strong>
 </span>
 @enderror
</div>
<div class="col-12 col-md-4 mt-2 pt-1 pr-md-0">
   <input id="phone_number" type="text"
   class="form-control grey-ph h-auto py-4 rounded-0 @error('phone_number') is-invalid @enderror" name="phone_number"
   value="{{ old('phone_number') }}" autocomplete="phone_number" autofocus
   placeholder="{{trans('custom.phone_number')}}">

   @error('phone_number')
   <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
   </span>
   @enderror
</div>
<div class="col-12 col-md-8 mt-2 pt-1 pl-md-2">
    <input id="address" type="text" class="form-control grey-ph h-auto py-4 rounded-0 @error('address') is-invalid @enderror"
    name="address" value="{{ old('address') }}" autocomplete="address" autofocus
    placeholder="{{trans('custom.address')}}">

    @error('address')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
<div class="col-12 col-md-4 mt-2 pt-1 pr-md-0">
    <input id="city" type="text" class="form-control grey-ph h-auto py-4 rounded-0 @error('city') is-invalid @enderror"
    name="city" value="{{ old('city') }}" autocomplete="city" autofocus
    placeholder="{{trans('custom.city')}}">

    @error('city')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
<div class="col-12 col-md-4 mt-2 pt-1 pr-md-0 pl-md-2">
    <input id="state" type="text" class="form-control grey-ph h-auto py-4 rounded-0 @error('state') is-invalid @enderror"
    name="state" value="{{ old('state') }}" autocomplete="state" autofocus
    placeholder="{{trans('custom.state')}}">

    @error('state')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
<div class="countryf col-12 col-md-4 mt-2 pt-1 pl-md-2">
   {{Form::select('country',[null => trans('custom.select_country')] + $country,'',['class' => 'form-control text-grey font-weight-bold h-auto py-4 rounded-0','id'=>'country_id'])}}
   @error('country')
   <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
<div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
    <input id="email" type="text" class="form-control grey-ph h-auto py-4 rounded-0 @error('email') is-invalid @enderror"
    name="email" value="{{ old('email') }}" autocomplete="email" autofocus
    placeholder="{{trans('custom.email')}}">

    @error('email')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror

</div>
<div class="col-12 col-md-6 mt-2 pt-1 pl-md-2">
 <input id="confirm_email" type="text"
 class="form-control grey-ph h-auto py-4 rounded-0 @error('confirm_email') is-invalid @enderror" name="confirm_email"
 value="{{ old('confirm_email') }}" id="confirm_email" autocomplete="confirm_email" autofocus
 placeholder="{{trans('custom.repeat_email')}}">

 @error('confirm_email')
 <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
<div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
    <input id="password" type="password"
    class="form-control grey-ph h-auto py-4 rounded-0 @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autocomplete="password" autofocus
    placeholder="{{ trans('custom.login_password') }}">

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
 class="form-control grey-ph h-auto py-4 rounded-0 @error('secure_password') is-invalid @enderror" name="secure_password"
 value="{{ old('secure_password') }}" autocomplete="secure_password" autofocus
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
    name="confirm_secure_password" value="{{ old('confirm_secure_password') }}" id="confirm_secure_password" 
    autocomplete="confirm_secure_password" autofocus
    placeholder="{{ trans('custom.repeat_security_password') }}">

    @error('confirm_secure_password')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
</div>              
</fieldset>
<h1 class="text-uppercase">{{trans('custom.BANK_DETAILS')}}</h1>
<fieldset>
   <div class="row justify-content-center mt-5">                     
     <div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
        <input id="bank_name" type="text" class="form-control grey-ph h-auto py-4 rounded-0 @error('bank_name') is-invalid @enderror"
        name="bank_name" value="{{ old('bank_name') }}" autocomplete="bank_name" autofocus
        placeholder="{{ trans('custom.name_of_bank') }}">

        @error('bank_name')
        <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
     </span>
     @enderror
 </div>
 <div class="col-12 col-md-6 mt-2 pt-1 pl-md-2">
     <input readonly id="acc_holder_name" type="text"
     class="form-control grey-ph h-auto py-4 rounded-0 @error('acc_holder_name') is-invalid @enderror" name="acc_holder_name"
     value="{{ old('acc_holder_name') }}" autocomplete="acc_holder_name" autofocus
     placeholder="{{ trans('custom.name_account_holder') }}">

     @error('acc_holder_name')
     <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
     </span>
     @enderror
 </div>
 <div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
    <input id="bank_branch" type="text"
    class="form-control grey-ph h-auto py-4 rounded-0 @error('bank_branch') is-invalid @enderror" name="bank_branch"
    value="{{ old('bank_branch') }}" autocomplete="bank_branch" autofocus
    placeholder="{{ trans('custom.bank_branch_only') }}">

    @error('bank_branch')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
<div class="col-12 col-md-6 mt-2 pt-1 pl-md-2">
  <input id="swift_code" type="text"
  class="form-control grey-ph h-auto py-4 rounded-0 @error('swift_code') is-invalid @enderror" name="swift_code"
  value="{{ old('swift_code') }}" autocomplete="swift_code" autofocus
  placeholder="{{ trans('custom.swift_code') }}">

  @error('swift_code')
  <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
<div class="col-12 col-md-6 mt-2 pt-1 pr-md-0">
  <input id="acc_number" type="text"
  class="form-control grey-ph h-auto py-4 rounded-0 @error('acc_number') is-invalid @enderror" name="acc_number"
  value="{{ old('acc_number') }}" autocomplete="acc_number" autofocus
  placeholder="{{ trans('custom.account_number') }}">

  @error('acc_number')
  <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
<div class="bankc col-12 col-md-6 mt-2 pt-1 pl-md-2">

 {{Form::select('bank_country_id',[null => trans('custom.select_bank_account_country')] + $country,'',['class' => 'form-control text-grey font-weight-bold h-auto py-4 rounded-0'])}}
 @error('bank_country_id')
 <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>
</div>
</fieldset>
<h1>{{ trans('custom.user_agreement') }}</h1>
<fieldset>
  <div class="row justify-content-center mt-5">
   {{-- <div class="col-12 text-white">
    <h4>By creating an account at example, you agree and comply that:</h4>
<ul><li>All input information is accurate and true to your best knowledge;</li>
<li>You adhere to provide additional information to prove such validity if required;</li>
<li>The security of your account (password) is your responsibility and any breach that stems from your personal password being leaked is your responsibility;</li>
<li>You are of adult age in the jurisdiction in which you reside;</li>
<li>Your use of example products and offerings do not violate any applicable law or regulation;</li>
<li>Your use of the service is at your sole risk. The service is provided on an "As is" and "As available" basis. Except as otherwise expressly provided herein, example expressly disclaims all warranties of any kind, whether express, implied or statutory, including, but not limited to the implied warranties of merchantability, fitness for a particular purpose, title, and non-infringement.</li>

<li>You understand and agree that the above dispute procedures shall be your sole remedy in the event of dispute between you and example regarding any aspect of the service (including the enrolment process) and that you are waiving your right to lead or participate in a lawsuit involving other persons, such as a class action.</li>

<li>You agree that example, in its sole discretion and without liability to you or any third party, may suspend or terminate your use of service (or any part thereof) and remove and discard any content within the service, for any reason, including, without limitation, for lack of use or if example believes that you have violated or acted inconsistently with the letter or spirit of these terms of service.</li>
     </ul>
</div> --}}
{!! trans('custom.user_aggrement_list') !!}
</div>

<div class="row mt-3 mb-3 ticks">
<div class="col-12 col-md-6 form-group row">
    {{-- <div class="col-md-12"><h4 style="color:#fff">Please tick the following the complete your registration:</h4>
    <p style="color:#fff">I agree I have read the following documents and adhere to the terms and conditions that has been outlined in the documents below:</p>
    </div> --}}
    {!! trans('custom.click_to_finish_registration') !!}
   <div class="col-md-12 user-agrrement-errro">
      <label class="m-checkbox">
         <input class="chk_agreements " type="checkbox" id="antimoney_laundering" name="terms_condition[]" value="antimoney_laundering" >
         <a href="{{asset('terms/example-Anti-Money-Laundering.pdf')}}" target="_blank" class="font-regular text-white">{{ trans('custom.antimoney-laundering') }}</a>
         <span></span><br>
         <label id="terms_condition[]-error" class="error" for="terms_condition[]"></label>
     </label>
 </div>
 <div class="col-md-12">
  <label class="m-checkbox">
     <input class="chk_agreements " type="checkbox" name="terms_condition[]" value="coockie_policy" id="coockie_policy" >
     <a href="{{asset('example-Cookie-Policy.pdf')}}" target="_blank" class="font-regular text-white">{{ trans('custom.coockie-policy') }}</a>
     <span></span>
 </label>
</div>                             
<div class="col-md-12 ">
  <label class="m-checkbox">
     <input class="chk_agreements " type="checkbox" id="privacy_policy" name="terms_condition[]" value="privacy_policy" >
     <a href="{{asset('terms/example-Privacy-Policy.pdf')}}" target="_blank" class="font-regular text-white">{{ trans('custom.privacy_policy_label') }}</a>
     <span></span>
 </label>
</div>
<div class="col-md-12">
  <label class="m-checkbox">
     <input class="chk_agreements " type="checkbox" id="risk_disclosure" name="terms_condition[]" value="risk_disclosure" >
     <a href="{{asset('terms/example-Risk-Disclosure.pdf')}}" target="_blank" class="font-regular text-white">{{ trans('custom.risk_disclosure_statement') }}</a>
     <span></span>
 </label>
</div>
<div class="col-md-12">
  <label class="m-checkbox">
     <input class="chk_agreements " type="checkbox" id="terms_and_condition" name="terms_condition[]" value="terms_and_condition" >
     <a href="{{asset('terms/example-Terms-of-Use.pdf')}}" target="_blank" class="font-regular text-white">{{ trans('custom.terms_and_condition') }}</a>
     <span></span>
 </label>
</div>
</div>
 <!-- <div class="col-12 col-md-6 sigbox">
   <div class="card rounded-0">
      <div class="card-body">
        <label class="" for="">{{__('custom.signature')}}</label>
        <br/>
        <div id="sigpad"></div>
        <br><br>
        <button id="clear" class="btn btn-danger rounded-0">{{__('custom.clear_signature')}}</button>
        <textarea id="signature" name="signature" style="display: none"></textarea>
    </div>
</div>
</div>
 --></div>
</fieldset>
</form> 
</div>
</div>
</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">



// A $( document ).ready() block.
$( document ).ready(function() {
    $('#fullname').on('keypress keydown keyup',function(){
    var name = $(this).val();
    $('#acc_holder_name').val(name);
    });
});




    // $(document).on("change", "input[name=child_position]", function(e) {
    //     $("#placement_check").val('');
    // });
    $(document).on("click", ".verify-sponser", function(e) {
        // alert('ad');
        var $this = this;
        var sponsor_username = $("#sponsor_username").val();
        $.ajax({
            type: "POST",
            url: sponsorUsernameExits,
            cache: false,
            data: {
                _token: $("input[name=_token]").val(),
                sponsor_username: sponsor_username,
            },
            success: function(data) {
                var parsed_data = JSON.parse(data);
                if (parsed_data.valid == true) {
                    $("#sponsor_check").val(sponsor_username);
                    $(".cus-success-sponsor").show(100);
                    $(".cus-error-sponsor").hide(100);
                    $(".sponsor_check-error").hide(100);
                    $("#sponsor_check-error").hide(100);
                    $("#sponsor_username").removeClass('error');
                    $("#sponsor_username-error").hide(100);
                } else {
                    $(".cus-error-sponsor").show(100);
                    $("#sponsor_username-error").show(100);
                    $(".cus-success-sponsor").hide(100);
                }
            }
        });
    });

    $(document).on("click", ".verify-placement", function(e) {
        // alert('ad');
        var $this = this;
        var placement_username = $('#placement_username').val();
        var sponsor_check = $("#sponsor_check").val();
        // var child_position = $("input[name='child_position']:checked").val();

        $.ajax({
            type: "POST",
            url:placementUsernameExits,
            cache: false,
            data: {
                _token: $("input[name=_token]").val(),
                placement_username:placement_username,
                sponsor_check:sponsor_check,
                // child_position:child_position
            },
            success: function(data) {
                var parsed_data = JSON.parse(data);
                if (parsed_data.valid == true) {
                    $("#placement_check").val(placement_username);
                    $(".cus-success-placement").show(100);
                    $(".cus-error-placement").hide(100);
                    $(".placement_check-error").hide(100);
                    $("#placement_check-error").hide(100);
                    $("#placement_username").removeClass('error');
                    $("#placement_username-error").hide(100);
                } else {
                    $(".cus-error-placement").show(100);
                    $("#placement_username-error").show(100);
                    $(".cus-success-placement").hide(100);
                }
            }
        });
    });
   // window.onload = function() {
   //    const myInput = document.getElementById('confirm_email');
   //    myInput.onpaste = function(e) {
   //       e.preventDefault();
   //    }
   //    const myInput1 = document.getElementById('password_confirmation');
   //    myInput1.onpaste = function(e) {
   //       e.preventDefault();
   //    }
   //    const myInput2 = document.getElementById('confirm_secure_password');
   //    myInput2.onpaste = function(e) {
   //       e.preventDefault();
   //    }
   // }
   jQuery.validator.addMethod("issponserverified", function(value, element) {
    var sponser_username = $('#sponsor_username').val().trim();
    var varifiedSponser = $('#sponsor_check').val();
    if(varifiedSponser != '' && sponser_username != varifiedSponser){
        return false;
    }  else if(sponser_username !=  '' && varifiedSponser == ''){
        return false;
    } else {
        return  true;
    }
}, verify_entered_sponsor);
   jQuery.validator.addMethod("isplacementverified", function(value, element) {
    var placement_username = $('#placement_username').val().trim();
    var varifiedPlacement = $('#placement_check').val();
    if(varifiedPlacement != '' && placement_username != varifiedPlacement){
        return false;
    }  else if(placement_username !=  '' && varifiedPlacement == ''){
        return false;
    } else {
        return  true;
    }
}, verify_entered_sponsor);

   jQuery.validator.addMethod("checksponserverified", function(value, element) {
    var sponser_username = $('#sponsor_username').val().trim();
    var varifiedSponser = $('#sponsor_check').val();
    if(varifiedSponser != '' && sponser_username != varifiedSponser){
        return false;
    }  else if(sponser_username !=  '' && varifiedSponser == ''){
        return false;
    }  else if(sponser_username ==  ''){
        return false;
    } else {
        return  true;
    }
}, "{{ trans('custom.please_verify_the_sponsor_id_first') }}");
   $.validator.addMethod(
    "alphanumeric1",
    function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\b]+$/i.test(value);
    },
    consists_letters_numbers_only
    );
   // $.validator.addMethod(
   //  "max3allowed",
   //  function(value, element) {
   //      var result =true;
   //      result=$.ajax({
   //          url: icNumberDuplication,
   //          type: "post",
   //           async: false,
   //          data: {
   //              _token: $("input[name=_token]").val(),
   //              sponsor_username: function() {
   //                  return $( "#sponsor_username" ).val();
   //              },
   //              ic_number: value,
   //          },
   //          done: function(data,result) {
   //              var data = JSON.parse(data);
   //              if (data.valid == 'false') {
   //                  result= false;
   //              } 
   //              result= true;
   //          }
   //  }).responseText;
   //      var data = JSON.parse(result);
   //      if (data.valid == 'false') {
   //                  return false;
   //              } 
   //                  return true;
   //      return response;
   // },
   // max_3_identfication_allowed
   // );

   $("#form-wizards-register").steps({
     bodyTag: "fieldset",
     labels:{
      finish: '<button class="btn bg-warning text-white py-4 px-5 font-weight-bold rounded-0 mt-4 mt-md-2 font-18 text-uppercase" id="finish">{{trans("custom.finish")}}</button>',
      next: '<button class="btn bg-warning text-white py-4 px-5 font-weight-bold rounded-0 mt-4 mt-md-2 font-18 text-uppercase">{{trans("custom.next")}} <img src="{{ asset("assets/images/assets/Staking_Pools/Group179.png") }}" class="img-fluid ml-3 align-middle" alt=""></button>',
      previous: '<button class="btn bg-transparent border-warning text-white py-4 px-5 mt-4 mt-md-2 font-weight-bold rounded-0 font-18 text-uppercase"><img src="{{ asset("assets/images/assets/Staking_Pools/Group179.png") }}" class="img-fluid mr-3 align-middle" alt="" style="transform: rotate(180deg);">{{trans("custom.previous")}}</button>'
  },
  onInit: function (event, current) {
    var sigpad = $('#sigpad').signature({syncField: '#signature', syncFormat: 'PNG',background: 'transparent'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sigpad.signature('clear');
        $("#signature").val('');
    });
    $('.actions > ul > li:first-child').attr('style', 'display:none');
},
onStepChanging: function (event, currentIndex, newIndex)
{
  $('.actions > ul > li:first-child').attr('style', 'display:block');


            // Always allow going backward even if the current step contains invalid fields!
            if (currentIndex > newIndex)
            {
             return true;
         }

            // Forbid suppressing "Warning" step if the user is to young
            if (newIndex === 2 && Number($("#age").val()) < 18)
            {
             return false;
         }

         var form = $(this);

            // Clean up if user went backward before
            if (currentIndex < newIndex)
            {
                // To remove error styles
                $(".body:eq(" + newIndex + ") label.error", form).text('');
                $(".body:eq(" + newIndex + ") .error", form).text("");
            }

            // Disable validation on fields that are disabled or hidden.
            form.validate().settings.ignore = ":disabled,:hidden";

            // Start validation; Prevent going forward if false
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            // Suppress (skip) "Warning" step if the user is old enough.
            if (currentIndex === 2 && Number($("#age").val()) >= 18)
            {
             $(this).steps("next");
         }

            // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
            if (currentIndex === 2 && priorIndex === 3)
            {
             $(this).steps("previous");
         }
     },
     onFinishing: function (event, currentIndex)
     {
         var form = $(this);

            // Disable validation on fields that are disabled.
            // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
            form.validate().settings.ignore = ":disabled";

            // Start validation; Prevent form submission if false
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            var form = $(this);

            // Submit form input
            form.submit();
        }
    }).validate({
       errorPlacement: function (error, element)
       {
        element.after(error);
    },
    ignore: "input[type='text']:hidden",
    rules: {
      sponsor_username: {
         required: true,
         alphanumeric : true,
         minlength: 3,
         maxlength: 50,
         issponserverified: true,
                           // remote: {
                           //     url: sponsorUsernameExits,
                           //     type: "post",
                           //     data: {
                           //         _token: $("input[name=_token]").val()
                           //     },
                           //     dataFilter: function(data) {
                           //         var data = JSON.parse(data);
                           //         if (data.valid != true) {
                           //             return false;
                           //         } else {
                           //             return true;
                           //         }
                           //     }
                           // }
                       },
                       placement_username: {
                           required: true,
                           checksponserverified: true,
                           isplacementverified:true

                       },
                       sponsor_check: {
                           required: true,
                       },
                       placement_check: {
                           required: true,
                       },
                       fullname: {
                         required: true,
                         maxlength: 50,
                     },
                     username: {
                         required: true,
                         alphanumeric : true,
                         minlength: 3,
                         maxlength: 50,
                         remote: {
                          url: usernameExits,
                          type: "post",
                          data: {
                           _token: $("input[name=_token]").val()
                       },
                       dataFilter: function(data) {
                        var data = JSON.parse(data);
                        if (data.valid != true) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                }
            },
            address: {
             required: true,
             maxlength: 100,
         },
         city: {
             required: true,
             maxlength: 50,
         },
         state: {
             required: true,
             maxlength: 50,
         },
         country: {
             required: true,
         },
         ic_number: {
             required: true,
             alphanumeric1: true,
                           // max3allowed:true,
                         //   maxlength: function(){
                         //      if($('#country_id').val() == '131'){
                         //         return '12';
                         //     }
                         // },
                         checksponserverified: true,
                         // remote: {
                         //      url: icNumberDuplication,
                         //      type: "post",
                         //      data: {
                         //         _token: $("input[name=_token]").val(),
                         //         sponsor_username: function() {
                         //            return $( "#sponsor_username" ).val();
                         //        }
                         //            // ic_number: $(this).val(),
                         //        },
                         //        dataFilter: function(data) {
                         //            var data = JSON.parse(data);
                         //            if (data.valid == true || data.valid == 'false') {
                         //              return true;
                         //          } else {

                         //              return false;
                         //          }
                         //      }
                         //  }
                     },
                     email: {
                         required: true,
                         email: true,
                         maxlength: 50,
                         remote: {
                          url: emailExists,
                          type: "post",
                          data: {
                           _token: $("input[name=_token]").val()
                       },
                       dataFilter: function(data) {
                           var data = JSON.parse(data);
                           if (data.valid != true) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                }
            },
            confirm_email: {
             required: true,
             equalTo: "#email"
         },
         phone_number: {
             required: true,
             number: true,
             minlength:10,
             maxlength: 15,
         },
         password: {
             required: true,
             minlength:8,
             maxlength: 15
         },
         password_confirmation: {
             required: true,
             equalTo: "#password"
         },
         secure_password: {
             required: true,
             minlength:8,
             maxlength: 15
         },
         confirm_secure_password: {
             required: true,
             equalTo: "#secure_password"
         },
         bank_name:{
             required: true,
             maxlength: 50,
         },
         acc_holder_name:{
             required: true,
             maxlength: 50,
             equalTo: "#fullname"
         },
         acc_number:{
             required: true,
                           // number: true,
                           maxlength: 20,
                       },
                       swift_code:{
                         required: true,
                           // number: true,
                           maxlength: 20,
                       },
                       bank_branch:{
                         required: true,
                         maxlength: 50,
                     },
                     bank_country_id:{
                         required: true,
                     },
                     // signature:{
                     //     required: true,
                     //       // maxlength: 50,
                     //   },
                       // d_date:{
                       //     required: true,
                       // },
                       'terms_condition[]':{
                         required: true,
                         minlength: 5
                     },
      //                  // iagree:{
      //                  //     required: true,
      //                  // }
  },
  messages: {

    sponsor_username: {
       minlength: please_enter_least_3_characters,
       maxlength: please_enter_no_more_than_50,
       remote: please_check_sponsor_username_not_valid,
   },
   sponsor_check:{
       required: please_enter_sponsor_name
   },
   placement_username: {
       required: please_enter_placement_name,
   },
   placement_check:{
       required: please_enter_placement_name
   },
   fullname: {
       required: fullname_required,
       maxlength: please_enter_no_more_than_50,
   },
   username: {
       required: username_required_field,
       alphanumeric: letters_numbers_and_underscores_only_please,
       minlength: please_enter_least_3_characters,
       maxlength: please_enter_no_more_than_50,
       remote: username_already_exists,
   },
   address: {
       required: address_required_field,
       maxlength: please_enter_no_more_than_100,
   },
   city: {
       required: city_required_field,
       maxlength: please_enter_no_more_than_50,
   },
   state: {
       required: state_required_field,
       maxlength: please_enter_no_more_than_50,
   },
   country: {
       required: country_required_field,
   },
   ic_number: {
       required: ic_required_field,
       maxlength: please_enter_no_more_than_20,
       remote: identification_alread_use
   },
   email: {
       required: eamil_required_field,
       email: please_enter_valid_email_address,
       maxlength: please_enter_no_more_than_50,
       remote: email_already_exists
   },
   confirm_email: {
       required: eamil_required_field,
       equalTo: please_enter_same_value
   },
   phone_number: {
       required: phone_number_required_field,
       number: enter_valid_number,
       minlength:please_enter_least_10_characters,
       maxlength: please_enter_no_more_than_15,
   },
   password: {
       required: password_required_field,
       minlength:please_enter_least_8_characters,
       maxlength: please_enter_no_more_than_15
   },
   password_confirmation: {
       required: repeatpassword_required_field,
       equalTo: please_enter_same_value
   },
   secure_password: {
       required: securepassword_required_field,
       minlength:please_enter_least_8_characters,
       maxlength: please_enter_no_more_than_15
   },
   confirm_secure_password: {
       required: repeatsecurepassword_required_field,
       equalTo: please_enter_same_value
   },
   bank_name:{
       required: bankname_required_field,
       maxlength: please_enter_no_more_than_50,
   },
   acc_holder_name:{
       required: accountholder_required_field,
       maxlength: please_enter_no_more_than_50,
       equalTo: account_holder_name_and_full_name_same
   },
   acc_number:{
       required: accountnumber_required_field,
       maxlength: please_enter_no_more_than_20,
   },
   swift_code:{
       required: swift_code_required_field,
       maxlength: please_enter_no_more_than_20,
   },
   bank_branch:{
       required: bank_branch_required_field,
       maxlength: please_enter_no_more_than_50,
   },
   bank_country_id:{
       required: bank_country_required_field,
   },
   signature:{
       required: signature_required_field,
       maxlength: please_enter_no_more_than_50,
   },
   'terms_condition[]':{
     required: select_all,
     minlength: please_select_atleast_4_checkboxes
 },
                   // 'iagree':{
                   //     required: select_all,
                   // },
               },
           })
       </script>
       @endsection