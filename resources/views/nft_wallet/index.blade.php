@extends('layouts.app')
@section('title', __('custom.nft_wallet'))
@section('page_title', __('custom.nft_wallet'))
@section('content')
<style type="text/css">
.cpybtn{
    margin: 10px;
}
</style>
<div class="content-wrapper nft-wallet">
    <div class="ml-2 mb-4 d-none-desk d-md-block">
      <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
      @if(Route::currentRouteName() == 'dashboard')
      <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
      @endif
    </div>
  <div class="row mt-3">
    <div class="col-12">
      <div class="login-gradient rounded text-white py-4 px-5">
        <h2 class="mb-0 font-weight-bold">${{ number_format($userWallet->nft_wallet, 2)}}</h2>
        <p class="mb-0">{{ trans('custom.balance')}}</p>
      </div>
    </div>
  </div>
  <div class="row justify-content-center mt-4">
    <div class="col-12">
      <ul class="nav nav-tabs justify-content-center account-tabs border-0">
        <li><a class="text-warning border border-warning py-3 px-5 d-block fund-usdt-bank active" data-value="usdt" data-toggle="tab" href="#home">{{ trans('custom.usdt')}}</a></li>
        @if(\Auth::user()->country_id == 131)
                <li><a class="text-warning border border-warning py-3 px-5 d-block fund-usdt-bank" data-toggle="tab" data-value="myr-usdt" href="#menu1">{{ trans('custom.malaysia_opg')}}</a></li>
                @endif

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
        <div id="home" class="tab-pane active">
          <div class="card">
            <div class="card-body p-md-5">
              {{-- @include('nft_wallet.common') --}}
              <div class="row">
                <div class="col-12 pb-3">
                  <h4 class="font-weight-bold">{{ trans('custom.terms_conditions')}}</h4>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions1_usdt') !!}
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions2_usdt') !!}
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions3_usdt') !!}
                </div>
              </div>
              
              {{Form::open(['route' => 'nftWalletForm','class' => '','id' =>'nftwalletform','enctype' => 'multipart/form-data'])}}

             

              @if($usdtaddress)
              <?php $qrcode = $usdtaddress->value;
              if(\Session::get('usdt')){
                  $qrcode = \Session::get('usdt');
              }
              ?>
              {{-- <div class="row fund-usdt"> --}}
                 <div class="col-lg-8 form-group-sub row nopadding ">
                  @if($usdtaddress->image != '')

                  <div style="text-align:center" class="image-qr-dah col-lg-4">
                      <img src="{{$usdtaddress->image}}" class="center"  id="qr_image" style="width: 140px;">
                  </div>
                  @else
                  <div class="image-qr-dah col-lg-4">
                      {!! QrCode::size(140)->generate($qrcode); !!}
                  </div>
                  @endif

                  <div class="col-lg-8 row nopadding">
                          <div class="col-lg-8 form-group-sub select-bank-hide nopadding ">
                              <div class="form-group ">
                                <label class="mb-2 bmd-label-static nopadding">@lang('custom.type_of_payment_address')
                                  :<span class="text-red">*</span></label>
                                  <div class="from-inner-space">
                                      <select name="usdt_address" class="form-control" id="usdt_address">
                                          @foreach($usdtaddresses as $usdtaddress)
                                          <option value="{{$usdtaddress->value}}" image="{{$usdtaddress->getOriginal('image')}}"  @if(\Session::get('usdt') == $usdtaddress->value) selected @endif>{{$usdtaddress->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-8 nopadding">
                              <input type="text" readonly value="{{$qrcode}}" class="form-control" id="copy-class-textaddress">
                          </div>
                          <div class="col-lg-4 nopadding centButton">
                              <a href="javascript:;" class="btn btn-primary cpybtn" id="copy_address">{{trans('custom.click_to_copy')}}  <span style="display: none;" class="copy_text text-white ">{{trans('custom.copied')}}</span></a>
                          </div>
                      </div>
                  </div>
              {{-- </div> --}}



              @endif
              <div class="row mt-4">
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                  <input type="hidden" name="payment_method" value="usdt">
                  {{Form::text('amount',old('amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow credit_amount usdttt','placeholder' => trans('custom.amount_USD'),'data-usdrate' => @$convertedRateUSDT])}}
                </div>
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                  {{Form::text('converted_amount',old('converted_amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow usdt-converted_amount','placeholder' => trans('custom.usdt_amount') ,'readonly'=>'true'])}}
                </div>
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                  <input type="password" name="secure_password" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{ trans('custom.security_password')}}">
                </div>
              </div>
              <div class="row mt-4">  
                <div class="col-12 col-md-6 mt-4 mt-md-0">
                  <div class="fallback">
                    <input name="upload_proof" type="file" class="dropify" id="upload_proof"/>
                    <p>{{ trans('custom.USDT_Proof_extension_png_jpg_jpeg_pdf')}}</p>
                    @error('upload_proof')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <label style="display:none;" id="upload_proof-error" class="error" for="upload_proof"></label>  
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-xl-6 mt-4">
                  <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.topup_fund_submit')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
                </div>
              </div>
              {{Form::close()}}
            </div>
          </div>
        </div>
        <div id="menu1" class="tab-pane">
          <div class="card">
            <div class="card-body p-md-5">
              <div class="row">
                <div class="col-12 pb-3">
                  <h4 class="font-weight-bold">{{ trans('custom.terms_conditions')}}</h4>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions1_payment_gateway') !!}
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions2_payment_gateway') !!}
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions3_payment_gateway') !!}
                </div>
              </div>
              {{Form::open(['route' => 'nftWalletForm','class' => '','id' =>'nftwalletform-myr','enctype' => 'multipart/form-data'])}}
              <div class="row mt-4">
                <input type="hidden" name="payment_method" value="secureautopay">

                <div class="col-12 col-md-3 mt-4 mt-md-0">
                  {{Form::text('amount',old('amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow credit_amount_myr usdttt','placeholder' => trans('custom.amount_USD'),'data-myr-rate' => @$convertedRateMYR])}}
                </div>
                <div class="col-12 col-md-3 mt-4 mt-md-0">
                  {{Form::text('bank_amount',old('bank_amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow usdt-myr-converted_amount','placeholder' => trans('custom.myr_amount') ,'readonly'=>'true'])}}
                </div>
                <div class="col-12 col-md-3 mt-4 mt-md-0">
                  <input type="password" name="secure_password" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{ trans('custom.security_password')}}">
                </div>
                <div class="col-12 col-md-3 mt-4 mt-md-0">
                  {{Form::select('bank_id',$banks,old('bank_id'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.select_payment_bank'),'id'=>'bank_id'])}}
                </div>
                <div class="col-12 col-xl-6 mt-4">
                  <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.topup_fund_submit')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
                </div>
              </div>
              {{Form::close()}}
            </div>
          </div>
        </div>
        <div id="menu2" class="tab-pane">
          <div class="card">
            <div class="card-body p-md-5">
              {{-- @include('nft_wallet.common') --}}
              <div class="row">
                <div class="col-12 pb-3">
                  <h4 class="font-weight-bold">{{ trans('custom.terms_conditions')}}</h4>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions1_payment_gateway') !!}
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions2_payment_gateway') !!}
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                  {!! trans('custom.nft_wallet_terms_and_conditions3_payment_gateway') !!}
                </div>
                </div>
              {{Form::open(['route' => 'nftWalletForm','class' => '','id' =>'nftwalletform-coin','enctype' => 'multipart/form-data'])}}
              <div class="row mt-4">
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                  <input type="hidden" name="payment_method" value="coin-payment">
                  {{Form::text('amount',old('amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow credit_amount usdttt','placeholder' => trans('custom.amount_USD'),'data-usdrate' => @$convertedRateUSDT])}}
                </div>
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                  {{Form::text('converted_amount',old('converted_amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow usdt-converted_amount','placeholder' => trans('custom.usdt_amount') ,'readonly'=>'true'])}}
                </div>
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                  <input type="password" name="secure_password" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{ trans('custom.security_password')}}">
                </div>
                <div class="col-12 col-xl-6 mt-4">
                  <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.topup_fund_submit')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
                </div>
              </div>
              {{Form::close()}}
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
  <div class="table-responsive table-history">
    @include('nft_wallet/nft_walletajax')
  </div>
  @endsection
  @section('scripts')
  <script type="text/javascript">
    $('.credit_amount').on('change', function () {
      var val =  $(this).val();
      var usdRate =  $(this).attr('data-usdrate');
      $('.usdt-converted_amount').val((val * usdRate).toFixed(2));
    });
    $('.credit_amount_myr').on('change', function () {
      var val =  $(this).val();
      var usdRate =  $(this).attr('data-myr-rate');
      $('.usdt-myr-converted_amount').val((val * usdRate).toFixed(2));
    });
    var image_path = "{{asset('uploads/qr_image/')}}";
    $('#usdt_address').change(function(e){
        $('#copy-class-textaddress').val($(this).val());
        $('#qr_image').attr('src', image_path+'/'+e.target.selectedOptions[0].getAttribute("image"));
        location.reload(); 
    });
  </script>
  @endsection