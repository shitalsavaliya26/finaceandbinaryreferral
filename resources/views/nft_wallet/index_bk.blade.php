@extends('layouts.app')
@section('title', __('custom.nft_wallet'))
@section('page_title', __('custom.nft_wallet'))
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
              <div class="login-gradient rounded text-white py-4 px-5">
                <h2 class="mb-0 font-weight-bold">${{ number_format($wallet->nft_wallet, 2)}}</h2>
                <p class="mb-0">{{ trans('custom.balance')}}</p>
              </div>
            </div>
          </div>
          <div class="row justify-content-center mt-4">
            <div class="col-12">
              <ul class="nav nav-tabs justify-content-center account-tabs border-0">
                <li><a class="text-warning border border-warning py-3 px-5 d-block active" data-toggle="tab" href="#home">{{trans('custom.usdt')}}</a></li>
                
              </ul>
            </div>

            <div class="col-12">
              <div class="tab-content border-0">
                <div id="home" class="tab-pane active">
                  <div class="card">
                    <div class="card-body p-md-5">
                      <div class="row">
                        <div class="col-12 pb-3">
                          <h4 class="font-weight-bold">{{ trans('custom.terms_conditions')}}</h4>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                         
                            {!! trans('custom.nft_wallet_terms_and_conditions1') !!}
                          
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                         
                            {!! trans('custom.nft_wallet_terms_and_conditions2') !!}
                          
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                          
                            {!! trans('custom.nft_wallet_terms_and_conditions3') !!}

                        </div>
                      </div>
                      <div class="row mt-4">
                        <div class="col-12 col-md-4">
                          <select class="form-control text-grey font-weight-bold h-auto py-4 border-0 outline-0 shadow">
                            <option value="">{{trans('custom.select_fund_type')}}</option>
                          </select>
                        </div>
                        <div class="col-12 col-md-4 mt-4 mt-md-0">
                          <input type="text" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{trans('custom.amount')}}">
                        </div>
                        <div class="col-12 col-md-4 mt-4 mt-md-0">
                          <input type="text" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{trans('custom.security_password')}}">
                        </div>
                        <div class="col-12 col-xl-6 mt-4">
                          <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{trans('custom.topup_fund_submit')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="menu1" class="tab-pane">
                </div>
              </div>  
            </div>
          </div>
          <div class="table-responsive table-history">
            @include('nft_wallet.history')
          </div>
          <!-- content-wrapper ends -->
@endsection