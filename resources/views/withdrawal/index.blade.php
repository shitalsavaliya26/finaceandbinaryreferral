@extends('layouts.app')
@section('title', __('custom.withdrawals'))
@section('page_title', __('custom.withdrawals'))
@section('content')
<div class="content-wrapper">
    <div class="ml-2 mb-4 d-none-desk d-md-block">
      <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
      @if(Route::currentRouteName() == 'dashboard')
      <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
      @endif
  </div>
  <div class="row mt-3">
    <div class="col-12">
        <div class="withdrawal-gradient rounded text-white py-4 px-5">
            <h2 class="mb-0 font-weight-bold">${{number_format($userWallet->withdrawal_balance, 2)}}</h2>
            <p class="mb-0">{{ trans('custom.balance')}}</p>
        </div>
    </div>
</div>
<div class="row justify-content-center mt-4">
    <div class="col-12">
        <ul class="nav nav-tabs justify-content-center account-tabs border-0">
            <li><a class="text-warning border border-warning py-3 px-5 d-block" data-toggle="tab" href="#home">{{ trans('custom.usdt')}}(ERC-20)</a></li>
            <li><a class="text-warning border border-warning py-3 px-5 d-block" data-toggle="tab" href="#trc20">{{ trans('custom.usdt')}}(TRC-20)</a></li>
            <li><a class="text-warning border border-warning py-3 px-5 d-block active" data-toggle="tab" href="#menu1">{{ trans('custom.BANK')}}</a></li>
        </ul>
    </div>
    <div class="col-12">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ Session::get('success') }}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ Session::get('error') }}
        </div>
        @endif
        <div class="tab-content border-0">
            <div id="home" class="tab-pane">
                <div class="card">
                    <div class="card-body p-md-5">
                        @include('withdrawal.common')
                        {{Form::open(['route' => 'withdrawal-request','class' => '','id' =>'withdrawalform-usdt','enctype' => 'multipart/form-data'])}}
                        <div class="row mt-4">
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                <input type="hidden" name="payment_method" value="usdt">
                                {{Form::number('amount',old('amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.amount')])}}
                            </div>
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                <input type="password" name="secure_password" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{ trans('custom.security_password')}}">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                @if($user->usdt_address == '' || $user->usdt_address == null)
                                {{Form::text('usdt_address',old('usdt_address'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.USDT_address')])}}
                                @else
                                {{Form::text('usdt_address',$user->usdt_address,['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.USDT_address'), 'readonly' => 'true'])}}
                                @endif
                            </div>
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                @if($user->usdt_address == '' || $user->usdt_address == null || $user->usdt_image == '')
                                <div class="fallback">
                                    <input name="upload_proof" type="file" class="dropify" id="upload_proof"/>
                                    <p>{{ trans('custom.USDT_Proof_png_jpg_jpeg')}}</p>
                                    @error('upload_proof')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label style="display:none;" id="upload_proof-error" class="error" for="upload_proof"></label>
                                @else

                                <img width="auto" height="100px" src="{{asset('/uploads/withdrawl_request/'.$user->usdt_image)}}" class="img-responsive">
                                @endif  
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-xl-6 mt-4">
                                <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.REQUEST_FOR_WITHDRAWAL')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
            <div id="trc20" class="tab-pane">
                <div class="card">
                    <div class="card-body p-md-5">
                        @include('withdrawal.common')
                        {{Form::open(['route' => 'withdrawal-request','class' => '','id' =>'withdrawalform-usdt-trc','enctype' => 'multipart/form-data'])}}
                        <div class="row mt-4">
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                <input type="hidden" name="payment_method" value="usdt_trc">
                                {{Form::number('amount',old('amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.amount')])}}
                            </div>
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                <input type="password" name="secure_password" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{ trans('custom.security_password')}}">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                @if($user->usdt_trc_address == '' || $user->usdt_trc_address == null)

                                {{Form::text('usdt_address',old('usdt_address'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.USDT_address')])}}
                                @else
                                {{Form::text('usdt_address',$user->usdt_trc_address,['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.USDT_address'), 'readonly' => 'true'])}}
                                @endif
                            </div>
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                @if($user->usdt_trc_image == '')
                                <div class="fallback">
                                    <input name="upload_proof" type="file" class="dropify" id="upload_proof"/>
                                    <p>{{ trans('custom.USDT_Proof_png_jpg_jpeg')}}</p>
                                    @error('upload_proof')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label style="display:none;" id="upload_proof-error" class="error" for="upload_proof"></label>  
                                @else

                                <img width="auto" height="100px" src="{{asset('/uploads/withdrawl_request/'.$user->usdt_trc_image)}}" class="img-responsive">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-xl-6 mt-4">
                                <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.REQUEST_FOR_WITHDRAWAL')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
            <div id="menu1" class="tab-pane active">
                <div class="card">
                    <div class="card-body p-md-5">
                        @include('withdrawal.common')
                        {{Form::open(['route' => 'withdrawal-request','class' => '','id' =>'withdrawalform-bank','enctype' => 'multipart/form-data'])}}
                        <div class="row mt-4">
                            <div class="col-12 col-md-4 mt-4 mt-md-0">
                                <input type="hidden" name="payment_method" value="bank">
                                {{Form::number('amount',old('amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow credit_amount usdttt','placeholder' => trans('custom.amount')])}}
                            </div>
                            <div class="col-12 col-md-4 mt-4 mt-md-0">
                                <input type="password" name="secure_password" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{ trans('custom.security_password')}}">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-md-6 mt-4 mt-md-0">
                                <div class="fallback">
                                    <input name="upload_proof_bank" type="file" class="dropify" id="upload_proof_bank"/>
                                    <p>{{ trans('custom.Bank_Proof_png_jpg_jpeg')}}</p>
                                    @error('upload_proof_bank')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label style="display:none;" id="upload_proof_bank-error" class="error" for="upload_proof_bank"></label>  
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-xl-6 mt-4">
                                <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.REQUEST_FOR_WITHDRAWAL')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <h4 class="text-white pb-3">{{ trans('custom.withdrawal_history')}}</h4>
    </div>
    <div class="col-12">
        <div class="table-history">
        @include('withdrawal/withdrawlwalletajax')
        </div>
    </div>
</div>
<hr class="border-white mt-5" />
  <div class="row mt-5">
    <div class="col-12 col-xl-12">
      <div>
        <p class="text-white pb-3">{{__('custom.transfer_history')}}</p>
      </div>
      <div class="table-responsive table-history1">
        @include('withdrawal.history')
      </div>

    </div>
    </div>
@endsection