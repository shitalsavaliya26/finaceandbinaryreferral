@extends('layouts.app')
@section('title', __('custom.profile'))
@section('page_title', __('custom.profile'))
@section('content')
<div class="content-wrapper profile login-box">
  <div class="ml-2 mb-4 d-none-desk d-md-block">
    <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
    @if(Route::currentRouteName() == 'dashboard')
    <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
    @endif
  </div>
  <div class="row mt-3">
    <div class="col-12 col-xl-4 grid-margin stretch-card mb-0">
      <div class="card tale-bg overflow-hidden bg-white pb-3">
        <div class="bg-warning p-4 pb-5">
          <h4 class="text-white pb-2">{{trans('custom.my_profile')}}</h4>
        </div>
        <div class="px-4 cus-my-profile-img">
          <img src="{{asset($user->profile_image)}}" class="rounded-circle img-fluid" alt="">
          <a href="#profile-upload" data-toggle="modal" data-target="#profile-upload" class="font-10 d-block"><u>{{trans('custom.edit_photo')}}</u></a>
        </div>
        <div class="row px-4 mt-4">
          <div class="col-md-6">
            <h4 class="text-dark font-weight-bold mb-0">{{ @$user->name}}</h4>
            <span class="text-secondary font-12">{{trans('custom.full_name')}}</span>
          </div>
          {{-- <div class="col-md-6">
            <h4 class="text-dark font-weight-bold mb-0">Gold</h4>
            <span class="text-secondary font-12" >Rank</span>
          </div> --}}
        </div>
        <div class="row px-4 mt-4">
          <div class="col-md-6">
            <h4 class="text-secondary mb-0">{{ @$user->email}}</h4>
            <span class="text-secondary font-12">{{trans('custom.email')}}</span>
          </div>
          <div class="col-md-6">
            <h4 class="text-secondary mb-0">{{ @$user->phone_number}}</h4>
            <span class="text-secondary font-12">{{trans('custom.phone_number')}}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-8 mt-4 mt-xl-0">
      <div class="row">
        <div class="col-12">
          <div class="card" style="min-height: 306px;">
            <div class="card-body pb-xl-1 pt-xl-2">
              <div class="row align-items-center">
                <div class="col-12 col-xl-4">
                  <div class="col-12 col-md-9 mt-4">
                    <h4 class="text-black mb-0 font-weight-bold">{{ Helper::FinanceID($user->id, date("d-m-Y",strtotime($user->created_at)))}}</h4>
                    <span class="text-secondary font-10">{{trans('custom.finance_id')}}</span>
                  </div>
                  <div class="col-12 col-md-9 mt-4">
                    <h4 class="text-black mb-0 font-weight-bold">
                    @if (!empty($user->nft_wallet_address))
                    ******{{ substr($user->nft_wallet_address, -4)}}
                    @else
                      -
                    @endif
                    </h4>
                    <span class="text-secondary font-10">{{trans('custom.wallet_address')}}</span>
                  </div>
                  <div class="col-12 col-md-9 mt-4">
                    <h4 class="text-black mb-0 font-weight-bold">{{ date("d/m/Y",strtotime($user->created_at)) }}</h4>
                    <span class="text-secondary font-10">{{trans('custom.date_joined')}}</span>
                  </div>
                  <div class="col-12 col-md-9 mt-4">
                    <h4 class="text-black mb-0 font-weight-bold">{{ $staking_pool_count}}</h4>
                    <span class="text-secondary font-10">{{trans('custom.total_staking_package')}}</span>
                  </div>
                  {{-- <div class="row align-iems-center justify-content-between">
                    <div class="col-12 col-md-6">
                      <h4 class="text-black mb-0 font-weight-bold">{{ Helper::FinanceID($user->id, date("d-m-Y",strtotime($user->created_at)))}}</h4>
                      <span class="text-secondary font-10">{{trans('custom.finance_id')}}</span>
                    </div>
                    <div class="col-12 col-md-6">
                      <h4 class="text-black mb-0 font-weight-bold">
                      @if (!empty($user->nft_wallet_address))
                      ******{{ substr($user->nft_wallet_address, -4)}}
                      @else
                        -
                      @endif
                      </h4>
                      <span class="text-secondary font-10">{{trans('custom.wallet_address')}}</span>
                    </div>
                  </div>
                  <div class="row align-iems-center justify-content-between mt-4">
                    <div class="col-12 col-md-6">
                      <h4 class="text-black mb-0 font-weight-bold">{{ date("d/m/Y",strtotime($user->created_at)) }}</h4>
                      <span class="text-secondary font-10">{{trans('custom.date_joined')}}</span>
                    </div>
                    <div class="col-12 col-md-6">
                      <h4 class="text-black mb-0 font-weight-bold">{{ $staking_pool_count}}</h4>
                      <span class="text-secondary font-10">{{trans('custom.total_staking_package')}}</span>
                    </div>
                  </div> --}}
                </div>
                <div class="col-12 col-xl-8">
                  <div class="collection-slider">
                    <?php $i = 1; ?>
                    @foreach($staking_pool as $stakingpool)
                    @if($i == 1)
                    <div>
                      <div class="bg-card-{{$i}} text-center p-4 pb-5 rounded mx-2 position-relative">
                        <img src="{{asset('assets/images/assets/Dashboard/Group929.png')}}" class="img-fluid card-img-top" alt="">
                        <h4 class="text-white">{{$stakingpool->name}}</h4>
                        <p class="text-white font-12">{!! \Illuminate\Support\Str::limit($stakingpool->description,50) !!}</p>
                        <hr/>
                        <p class="text-white font-12">{{__('custom.expected_anual_rate')}}</p>
                        <h3 class="text-white font-weight-bold">{{$stakingpool->stacking_display_start}}% - {{$stakingpool->stacking_display_end}}%</h3>
                        @if($stakingpool->investedAmount > 0)
                        {{-- <div class="d-flex justify-content-around mt-2">
                          <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                          <button class="btn bg-blue text-white rounded-0 px-4">${{number_format($stakingpool->investedAmount,2)}}</button>
                        </div>
                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-1-btn position-absolute" href="{{ route('stakepool',$stakingpool->id) }}">{{__('custom.stake')}} <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}" class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a> --}}
                        <div class="d-flex justify-content-around mt-2">
                          <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                          <button class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                          </div>
                          <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}  <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                          class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                        @else
                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2" href="{{ route('stakepool',$stakingpool->id) }}">{{__('custom.stake')}} <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}" class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                        @endif
                      </div>
                    </div>
                    <div>
                      @elseif($i == 2)
                      <div class="bg-card-2 text-center p-4 pb-5 rounded mx-2 position-relative">
                        <img src="{{ asset('assets/images/assets/Dashboard/Group929.png') }}" class="img-fluid card-img-top" alt="">
                        <h4 class="text-white">{{$stakingpool->name}}</h4>
                        <p class="text-white font-12">{!! \Illuminate\Support\Str::limit($stakingpool->description,50) !!}</p>
                        <hr/>
                        <p class="text-white font-12">{{__('custom.expected_anual_rate')}}</p>
                        <h3 class="text-white font-weight-bold">{{$stakingpool->stacking_display_start}}% - {{$stakingpool->stacking_display_end}}%</h3>
                        @if($stakingpool->investedAmount > 0)
                        {{-- <div class="d-flex justify-content-around mt-2">
                          <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                          <button class="btn bg-blue text-white rounded-0 px-4">${{number_format($stakingpool->investedAmount,2)}}</button>
                        </div>
                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-2-btn position-absolute" href="{{ route('stakepool',$stakingpool->id) }}">{{__('custom.stake')}} <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}" class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a> --}}
                        <div class="d-flex justify-content-around mt-2 mb-4">
                          <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                          <button class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                          </div>
                          <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}  <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                          class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                        @else
                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2" href="{{ route('stakepool',$stakingpool->id) }}">{{__('custom.stake')}} <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}" class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                        @endif
                      </div>
                    </div>
                    <div>
                      @elseif($i == 3)
                      <div class="bg-card-3 text-center p-4 pb-5 rounded mx-2 position-relative">
                        <img src="{{ asset('assets/images/assets/Dashboard/Group929.png') }}" class="img-fluid card-img-top" alt="">
                        <h4 class="text-white">{{$stakingpool->name}}</h4>
                        <p class="font-12 text-white">{!! \Illuminate\Support\Str::limit($stakingpool->description,50) !!}</p>
                        <hr/>
                        <p class="text-white font-12">{{__('custom.expected_anual_rate')}}</p>
                        <h3 class="text-white font-weight-bold">{{$stakingpool->stacking_display_start}}% - {{$stakingpool->stacking_display_end}}%</h3>

                        @if($stakingpool->investedAmount > 0)
                        {{-- <div class="d-flex justify-content-around mt-2">
                          <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                          <button class="btn bg-blue text-white rounded-0 px-4">${{number_format($stakingpool->investedAmount,2)}}</button>
                        </div>
                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-3-btn position-absolute" href="{{ route('stakepool',$stakingpool->id) }}">{{__('custom.stake')}} <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}" class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a> --}}
                        <div class="d-flex justify-content-around mt-2 mb-4">
                          <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                          <button class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                          </div>
                          <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}  <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                          class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                        @else
                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2" href="{{ route('stakepool',$stakingpool->id) }}">{{__('custom.stake')}} <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}" class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                        @endif
                      </div>
                    </div>
                    @elseif($i == 4)
                    <div>
                      <div class="bg-card-4 text-center p-4 pb-5 rounded mx-2 position-relative">
                        <img src="{{ asset('assets/images/assets/Dashboard/Group929.png') }}" class="img-fluid card-img-top" alt="">
                        <h4>{{$stakingpool->name}}</h4>
                        <p class="font-12">{!! \Illuminate\Support\Str::limit($stakingpool->description,50) !!}</p>
                        <hr/>
                        <p class="text-blue font-12">{{__('custom.expected_anual_rate')}}</p>
                        <h3 class="text-blue font-weight-bold">{{$stakingpool->stacking_display_start}}% - {{$stakingpool->stacking_display_end}}%</h3>
                        @if($stakingpool->investedAmount > 0)
                        {{-- <div class="d-flex justify-content-around mt-2">
                          <p class="text-dark font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                          <button class="btn bg-blue text-white rounded-0 px-4">${{number_format($stakingpool->investedAmount,2)}}</button>
                        </div>
                        <a class="btn bg-warning text-white px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool',$stakingpool->id) }}">{{__('custom.stake')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a> --}}
                        <div class="d-flex justify-content-around mt-2 mb-4">
                          <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                          <button class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                          </div>
                          <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}  <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                          class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                        @else
                        <a class="btn bg-warning text-white px-3 rounded-0 font-10 mt-2" href="{{ route('stakepool',$stakingpool->id) }}">{{__('custom.stake')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-2 d-inline align-middle" alt=""></a>

                        @endif
                      </div>
                    </div>
                    @endif
                    <?php 
                    $i++; 
                    if($i == 5){
                      $i=1;
                    }
                    ?>

                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mt-5">
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
      <ul class="nav nav-tabs justify-content-center account-tabs border-0">
        <li><a class="text-warning border border-warning py-3 px-5 d-block active" data-toggle="tab" href="#home">{{trans('custom.PERSONAL_DETAILS')}}</a></li>
        <li class="mt-3 mt-md-0"><a class="text-warning border border-warning py-3 px-5 d-block" data-toggle="tab" href="#account-detail">{{trans('custom.accountdetails')}}</a></li> 
        <li class="mt-3 mt-md-0"><a class="text-warning border border-warning py-3 px-5 d-block" data-toggle="tab" href="#menu1">{{trans('custom.BANK_DETAILS')}}</a></li>
        <li class="mt-3 mt-xl-0"><a class="text-warning border border-warning py-3 px-5 d-block" data-toggle="tab" href="#menu2">{{trans('custom.NFT_WALLET_DETAILS')}}</a></li>
      </ul>
    </div>
    <div class="col-12 mt-4">
      <div class="tab-content border-0">
        <div id="home" class="tab-pane active">
          {!! Form::open(['route' => 'personal-detail-upadte','enctype' => 'multipart/form-data','id'=>'personal-detail-upadte', 'method'=>'POST'])!!}
          <div class="row">
            <div class="col-12 col-md-6">
              <input name="id" type="hidden" class="form-control blue-ph h-auto py-4" value="{{ $user->id }}">
              <input name="fullname" type="text" class="form-control blue-ph h-auto py-4" value="{{ $user->name }}"  placeholder="{{trans('custom.full_name')}}">
            </div>
            <div class="col-12 col-md-6 mt-4 mt-md-0">
              <input name="username" type="text" class="form-control blue-ph h-auto py-4" placeholder="{{trans('custom.username')}}" value="{{ $user->username }}" readonly="readonly">
            </div>
            <div class="col-12 col-md-6 mt-4">
              <input name="email" type="text" class="form-control blue-ph h-auto py-4" placeholder="{{trans('custom.email')}}" value="{{ $user->email }}" readonly="readonly">
            </div>
            <div class="col-12 col-md-6 mt-4">
              <input name="phone_number" type="text" class="form-control blue-ph h-auto py-4" value="{{ $user->phone_number}}" placeholder="{{trans('custom.phone_number')}}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              <input id="address" name="address" type="text" class="form-control blue-ph h-auto py-4"
              name="address" value="{{ $user->address }}" autocomplete="address" autofocus
              placeholder="{{trans('custom.address')}}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              <input type="text" name="state" class="form-control h-auto py-4" value="{{ $user->state }}" placeholder="{{trans('custom.state')}}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              <input type="text" name="city" class="form-control h-auto py-4" value="{{ $user->city }}" placeholder="{{trans('custom.city')}}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              {!! Form::select('country',$country,old('country_id', $user->country_id),['class'=>'form-control h-auto py-4','placeholder'=>trans('custom.select_country'),'id'=>'country_id']) !!}
            </div>
            <div class="col-12 col-md-6 col-xl-4 mt-4">
              <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{trans('custom.UPDATE_PROFILE')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div id="account-detail" class="tab-pane">
          {{Form::open(['route' => 'update-password','class' => 'password-update form-group ','id' =>'password-update'])}}
          {{ csrf_field() }}
          <div class="row">
            <div class="col-12 col-md-6 mt-4">
              <input type="password" name="password" class="form-control h-auto py-4" placeholder="{{trans('custom.password')}}" id="password">
            </div>
            <div class="col-12 col-md-6 mt-4">
              {{Form::password('confirm_password',['class' => 'form-control h-auto py-4','placeholder' => trans('custom.confirm_password')])}}
            </div>
            <div class="col-12 col-md-6 col-xl-4 mt-4">
              <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{trans('custom.UPDATE_PASSWORD')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
            </div>
          </div>
          {{Form::close()}}

          {{Form::open(['route' => 'update-secure-password','class' => 'password-update','id' =>'secure-password-update'])}}
          {{ csrf_field() }}
          <div class="row">
            <div class="col-12 col-md-6 mt-4">
              <input type="password" name="password" class="form-control h-auto py-4" placeholder="{{trans('custom.secure_password')}}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              {{Form::password('confirm_password',['class' => 'form-control h-auto py-4','placeholder' => trans('custom.enter_confrim_password'),'id' => 'secure_password'])}}
            </div>
            <div class="col-12 col-md-6 col-xl-4 mt-4">
              <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{trans('custom.UPDATE_SECURE_PASSWORD')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
            </div>
          </div>
          {{Form::close()}}
        </div>
        <div id="menu1" class="tab-pane">
          {!! Form::open(['route' => 'bank-detail-upadte','enctype' => 'multipart/form-data','id'=>'bank-detail-upadte', 'method'=>'POST'])!!}
          <div class="row">
            <input name="id" type="hidden" class="form-control blue-ph h-auto py-4" value="{{ $user->id }}">
            <div class="col-12 col-md-6">
              <input id="bank_name" type="text" class="form-control blue-ph h-auto py-4 @error('bank_name') is-invalid @enderror"
              name="bank_name" value="{{ @$user->userbank->name}}" autocomplete="bank_name" autofocus
              placeholder="{{ trans('custom.name_of_bank') }}">
            </div>
            <div class="col-12 col-md-6 mt-4 mt-md-0">
              <input id="acc_holder_name" type="text"
              class="form-control grey-ph h-auto py-4 rounded-0 @error('acc_holder_name') is-invalid @enderror" name="acc_holder_name"
              value="{{ @$user->userbank->account_holder }}" autocomplete="acc_holder_name" autofocus
              placeholder="{{ trans('custom.name_account_holder') }}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              <input id="bank_branch" type="text"
              class="form-control grey-ph h-auto py-4 rounded-0 @error('bank_branch') is-invalid @enderror" name="bank_branch"
              value="{{ @$user->userbank->branch }}" autocomplete="bank_branch" autofocus
              placeholder="{{ trans('custom.bank_branch_only') }}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              <input id="swift_code" type="text"
              class="form-control grey-ph h-auto py-4 rounded-0 @error('swift_code') is-invalid @enderror" name="swift_code"
              value="{{ @$user->userbank->swift_code }}" autocomplete="swift_code" autofocus
              placeholder="{{ trans('custom.swift_code') }}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              <input id="acc_number" type="text"
              class="form-control grey-ph h-auto py-4 rounded-0 @error('acc_number') is-invalid @enderror" name="acc_number"
              value="{{ @$user->userbank->account_number }}" autocomplete="acc_number" autofocus
              placeholder="{{ trans('custom.account_number') }}">
            </div>
            <div class="col-12 col-md-6 mt-4">
              {!! Form::select('bank_country_id',$country,old('bank_country_id', @$user->userbank->bank_country_id),['class'=>'form-control h-auto py-4','placeholder'=>trans('custom.select_country'),'id'=>'country_id']) !!}
            </div>
            <div class="col-12 col-md-6 col-xl-4 mt-4">
              <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.UPDATE_BANK_DETAILS') }} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div id="menu2" class="tab-pane">
          {!! Form::open(['route' => 'nft-wallet-address-update','enctype' => 'multipart/form-data','id'=>'nft-wallet-address-upadte', 'method'=>'POST'])!!}
          <div class="row">
            <input name="id" type="hidden" class="form-control blue-ph h-auto py-4" value="{{ $user->id }}">
            <div class="col-12 col-md-6">
              {!! Form::text('nft_wallet_address', old('nft_wallet_address', @$user->nft_wallet_address), ['class' => 'form-control blue-ph h-auto py-4', 'placeholder' => trans('custom.enter_nft_wallet_address')]) !!}
            </div>
            <div class="col-12 col-md-6 col-xl-4 mt-4"></div>
            <div class="col-12 col-md-6 col-xl-4 mt-4">
              <button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.UPDATE_NFT_WALLET_ADDRESS') }}<img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
            </div>

          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="profile-upload" aria-hidden="true" style="display: none;" id="profile-upload">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content  text-white">
        <div class="modal-header d-block ">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title mt-0">{{ trans('custom.upload_profile_image') }}</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              {{Form::open(['route' => 'updateImage','id' =>'profile-image-update','enctype' => 'multipart/form-data'])}}
              {{-- <div class="image-editor m-auto">
                <div class="cropit-preview"></div>
                <div class="image-size-label">Resize Image</div>
                <!-- <input type="range" class="cropit-image-zoom-input mt-2 mb-2 w-100  "> -->
                <input type="file" class="cropit-image-input d-none">
                <input type="hidden" class="image-value" name="profile_image"/>
                <button class="btn btn-info btn-sm float-left btn-f" type="button">Choose File</button>
                <button class="btn btn-success  btn-sm  float-right">Submit</button>
              </div> --}}
              <div class="fallback">
                <input name="profile_image" type="file" class="dropify" id="profile_image"/>
                <p>{{ trans('custom.profile_extension_png_jpg_jpeg') }}</p>
                @error('profile_image')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <label style="display:none;" id="profile_image-error" class="error" for="profile_image"></label>
              <button class="btn btn-success  btn-sm  float-right">{{ trans('custom.submit') }}</button>
              {{Form::close()}}

            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>

  @endsection