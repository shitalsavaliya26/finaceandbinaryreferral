@extends('layouts.app')
@section('title', __('custom.yield_wallet'))
@section('page_title', __('custom.yield_wallet'))
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
              <div class="yield-gradient rounded text-white py-4 px-5">
                <h2 class="mb-0 font-weight-bold">${{number_format($wallet->yield_wallet, 2)}}</h2>
                <p class="mb-0">{{ trans('custom.balance')}}</p>
              </div>
            </div>
          </div>
          <div class="row justify-content-center mt-4">
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
              <div class="card">
                <div class="card-body p-md-5">
                  <div class="row">
                    <div class="col-12 pb-3">
                      <h4 class="font-weight-bold">{{ trans('custom.terms_conditions')}}</h4>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                      {!! trans('custom.yield_wallet_terms_and_conditions1') !!}
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                      {!! trans('custom.yield_wallet_terms_and_conditions2') !!}
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                      {!! trans('custom.yield_wallet_terms_and_conditions3') !!}
                    </div>
                  </div>
                  {{Form::open(['route' => 'yield_wallet_store','class' => 'confirm-submit','id' =>'yield-wallet-confirm','enctype' => 'multipart/form-data'])}}
                  <div class="row mt-4">
                    <div class="col-12 col-md-4">
                      {{Form::select('fund_type',['0'=> trans('custom.crypto_wallet'),'1'=> trans('custom.withdrawal_wallet'), '2'=> trans('custom.nft_wallet')],old('type'),['class' => 'form-control text-grey font-weight-bold h-auto py-4 border-0 outline-0 shadow','placeholder' => trans('custom.fund_type_placeholder')])}}
                    </div>
                    <div class="col-12 col-md-4 mt-4 mt-md-0">
                      {{Form::number('amount',old('amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.amount_USD'), 'autocomplete' => 'off'])}}
                    </div>
                    <div class="col-12 col-md-4 mt-4 mt-md-0">
                      {{Form::password('secure_password',['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.security_password')])}}
                    </div>
                    <div class="col-12 col-xl-6 mt-4">
                      <button type="submit" class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.transfer_fund')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
                    </div>
                  </div>
                  {{Form::close()}}
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-12">
              <h4 class="text-white pb-3">{{ trans('custom.yield_wallet_history')}}</h4>
            </div>
            <div class="col-12">
              <div class="table-responsive">
                @include('yield_wallet.partials.history')
                {{-- <table class="table table-dark trading-table text-center">
                  <thead class="table-gradient">
                    <tr>
                      <th>DATE</th>
                      <th>AMOUNT</th>
                      <th>DESCRIPTION</th>
                      <th>STATUS</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-success">Approved</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-warning">Pending</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-success">Approved</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-success">Approved</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-danger">Reject</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-danger">Reject</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-danger">Reject</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-warning">Pending</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-warning">Pending</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-success">Approved</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                    <tr>
                      <td>12/09/2021</td>
                      <td>$1,000</td>
                      <td>Transfer To Withdrawal Wallet</td>
                      <td class="text-success">Approved</td>
                      <td>
                        <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}" class="img-fluid rounded-0 w-auto h-auto" alt="">
                      </td>
                    </tr>
                  </tbody>
                </table> --}}
              </div>
            </div>
          </div>
          <div class="row align-items-center mt-5">
            <div class="col-12 text-right">
              <div class="text-secondary">
                {{-- <img src="{{ asset('assets/images/assets/Sell_NFT/Path599.png') }}" class="img-fluid rotate-180" alt="">
                <span class="font-12 mx-1">1</span>
                <span class="font-12 mx-1 bg-warning px-1">2</span>
                <span class="font-12 mx-1">3</span>
                <span class="font-12 mx-1">4</span>
                <span class="font-12 mx-1">5</span>
                <span class="font-12 mx-1">6</span>
                <span class="font-12 mx-1">7</span>
                <span class="font-12 mx-1">8</span>
                <span class="font-12 mx-1">9</span>
                <span class="font-12 mx-1">10</span>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Path599.png') }}" class="img-fluid " alt=""> --}}
                {{$history->render('vendor.default_paginate')}}
              </div>
            </div>
          </div>
@endsection
@section('scripts')
<script type="text/javascript">
    var withdrawal_popup_txt = "{{trans('custom.withdrawal_popup_txt')}}";
</script>
@endsection