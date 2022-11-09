@extends('layouts.app')
@section('title', __('custom.my_collection'))
@section('page_title', __('custom.my_collection'))
@section('content')
<div class="content-wrapper">
  {{-- <div class="row mt-5 pt-5">
    <div class="col-12 col-xl-4 grid-margin stretch-card mb-0">
      <div class="card tale-bg overflow-hidden bg-white pb-3">
        <div class="bg-warning p-4 pb-5">
          <h4 class="text-white pb-2">My profile</h4>
        </div>
        <div class="px-4 cus-my-profile-img">
          <img src="{{ asset('assets/images/assets/Dashboard/Group853.png') }}" class="rounded-circle img-fluid" alt="">
        </div>
        <div class="row px-4 mt-4">
          <div class="col-md-6">
            <h4 class="text-dark font-weight-bold mb-0">Andy John</h4>
            <span class="text-secondary font-12">Full name</span>
          </div>
          <div class="col-md-6">
            <h4 class="text-dark font-weight-bold mb-0">Gold</h4>
            <span class="text-secondary font-12" >Rank</span>
          </div>
        </div>
        <div class="row px-4 mt-4">
          <div class="col-md-6">
            <h4 class="text-secondary mb-0">andy@outlook.com</h4>
            <span class="text-secondary font-12">Email</span>
          </div>
          <div class="col-md-6">
            <h4 class="text-secondary mb-0">+6012355678</h4>
            <span class="text-secondary font-12">Phone number</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-8 mt-4 mt-xl-0">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body pb-xl-1 pt-xl-2">
              <div class="row align-items-center">
                <div class="col-12 col-xl-4">
                  <div class="row align-iems-center justify-content-between">
                    <div class="col-12 col-md-6">
                      <h4 class="text-black mb-0 font-weight-bold">28928475</h4>
                      <span class="text-secondary font-10"> ID</span>
                    </div>
                    <div class="col-12 col-md-6">
                      <h4 class="text-black mb-0 font-weight-bold">******5749</h4>
                      <span class="text-secondary font-10">Phone number</span>
                    </div>
                  </div>
                  <div class="row align-iems-center justify-content-between mt-4">
                    <div class="col-12 col-md-6">
                      <h4 class="text-black mb-0 font-weight-bold">4/8/2020</h4>
                      <span class="text-secondary font-10">Date Joined</span>
                    </div>
                    <div class="col-12 col-md-6">
                      <h4 class="text-black mb-0 font-weight-bold">6</h4>
                      <span class="text-secondary font-10">Total Staking Packag</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-xl-8">
                  <div class="collection-slider">
                    <div>
                      <div class="bg-card-1 text-center p-4 rounded mx-2">
                        <img src="{{ asset('assets/images/assets/My_Collection/Group610.png') }}" class="img-fluid w-60 mx-auto card-img-top" alt="">
                        <h5 class="text-white mt-3">ALPHA</h5>
                        <p class="text-white font-10">The Cosmos Hub keeps track of balances and
                          routes transactions through the internet of
                        blockchains.</p>
                        <hr class="border-white my-1"/>
                        <p class="text-white font-10">Expected Annual Reward Rate</p>
                        <h4 class="text-white font-weight-bold">5% - 10%</h4>
                        <div class="d-flex align-items-center justify-content-center mt-3">
                          <span class="font-10 font-weight-bold mr-2 mb-0">Invested <br/> Amounts</span>
                          <button class="btn bg-blue text-white rounded-0 px-4 font-12 py-2">$20,000</button>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="bg-card-2 text-center p-4 rounded mx-2">
                        <img src="{{ asset('assets/images/assets/My_Collection/Group610.png') }}" class="img-fluid w-60 mx-auto card-img-top" alt="">
                        <h5 class="text-white mt-3">ALPHA</h5>
                        <p class="text-white font-10">The Cosmos Hub keeps track of balances and
                          routes transactions through the internet of
                        blockchains.</p>
                        <hr class="border-white my-1"/>
                        <p class="text-white font-10">Expected Annual Reward Rate</p>
                        <h4 class="text-white font-weight-bold">5% - 10%</h4>
                        <div class="d-flex align-items-center justify-content-center mt-3">
                          <span class="font-10 font-weight-bold mr-2 mb-0">Invested <br/> Amounts</span>
                          <button class="btn bg-blue text-white rounded-0 px-4 font-12 py-2">$20,000</button>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="bg-card-3 text-center p-4 rounded mx-2">
                        <img src="{{ asset('assets/images/assets/My_Collection/Group610.png') }}" class="img-fluid w-60 mx-auto card-img-top" alt="">
                        <h5 class="text-white mt-3">ALPHA</h5>
                        <p class="text-white font-10">The Cosmos Hub keeps track of balances and
                          routes transactions through the internet of
                        blockchains.</p>
                        <hr class="border-white my-1"/>
                        <p class="text-white font-10">Expected Annual Reward Rate</p>
                        <h4 class="text-white font-weight-bold">5% - 10%</h4>
                        <div class="d-flex align-items-center justify-content-center mt-3">
                          <span class="font-10 font-weight-bold mr-2 mb-0">Invested <br/> Amounts</span>
                          <button class="btn bg-blue text-white rounded-0 px-4 font-12 py-2">$20,000</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
 
  <div class="row mt-5 w-100">
    @if(count($collections) > 0)
    @foreach($collections as $value)
    <div class="col-12 col-md-6 col-xl-3" style="padding-top: 20px;">
      <a class="min-h-252 bg-white p-3 rounded mx-2 d-block w-100 text-decoration-none" href="{{route('nftproduct', $value->product_id)}}">
        <div class="position-relative overflow-hidden">
          <img src="{{ asset($value->nftproduct->image) }}" class="img-fluid w-100" alt="">
          @if($value->status == 2)
          <span class="sale-label">{{ __('custom.on_sale')}}</span>
          @endif
        </div>
        <div class="mt-3">
          <h4 class="text-blue font-weight-bold">{{ $value->nftproduct->name }}</h4>
          <h3 class="text-black font-weight-bold">${{ $value->amount }}</h3>
          <span class="text-secondary">{{ date("d/m/Y",strtotime($value->created_at)) }}</span>
        </div>
      </a>
    </div>
    @endforeach
    @else
    <div class="col-12">
      <p class="text-white font-weight-bold">{{ __('custom.no_collection_found')}}</p>
    </div>
    @endif
  </div>
  <div class="row mt-5 w-100">
   {{--  <div class="col-12 col-md-6 col-xl-3 mt-4 mt-md-0">
    <div class="min-h-252 bg-white p-3 rounded mx-2">
      <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1045.png') }}" class="img-fluid w-100" alt="">
      <div class="mt-3">
        <h4 class="text-blue font-weight-bold">KONG #7097</h4>
        <h3 class="text-black font-weight-bold">$20,000</h3>
        <span class="text-secondary">03/8/2021</span>
      </div>
    </div>
  </div> --}}
  {{--  <div class="col-12 col-md-6 col-xl-3 mt-4 mt-xl-0">
    <div class="min-h-252 bg-white p-3 rounded mx-2">
      <div class="position-relative overflow-hidden">
        <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1046.png') }}" class="img-fluid w-100" alt="">
        <span class="sale-label">ON SALE</span>
      </div>
      <div class="mt-3">
        <h4 class="text-blue font-weight-bold">KONG BOSS#7097</h4>
        <h3 class="text-black font-weight-bold">$20,000</h3>
        <span class="text-secondary">03/8/2021</span>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-xl-3 mt-4 mt-xl-0">
    <div class="min-h-252 bg-white p-3 rounded mx-2">
      <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1047.png') }}" class="img-fluid w-100" alt="">
      <div class="mt-3">
        <h4 class="text-blue font-weight-bold">BULL KONG #7097</h4>
        <h3 class="text-black font-weight-bold">$20,000</h3>
        <span class="text-secondary">03/8/2021</span>
      </div>
    </div>
  </div> --}}
  <div class="ml-4 d-none d-md-block">
    <h2 class="text-warning font-weight-bold">{{__('custom.nft_withdrawal')}}</h2>
  </div>
  <div id="home" class="tab-pane">
    <div class="card">
      <div class="card-body p-md-5">
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
        <div class="row">
          <div class="col-12 pb-3">
            <h4 class="font-weight-bold">{{ trans('custom.terms_conditions')}}</h4>
          </div>
          <div class="col-12 col-md-6 col-xl-4">
            {!! trans('custom.nft_withdrawal_wallet_terms_and_conditions1') !!}
          </div>
          <div class="col-12 col-md-6 col-xl-4">
            {!! trans('custom.nft_withdrawal_wallet_terms_and_conditions2') !!}
          </div>
          <div class="col-12 col-md-6 col-xl-4">
            {!! trans('custom.nft_withdrawal_wallet_terms_and_conditions3') !!}
          </div>
        </div>
        {{Form::open(['route' => 'nftwithdrawal-request','class' => '','id' =>'nftwithdrawalform','enctype' => 'multipart/form-data'])}}
        <div class="row mt-4">
          <div class="col-12 col-md-6 mt-4 mt-md-0">
            <input type="hidden" name="payment_method" value="usdt">
            <select name="product_id" class="form-control text-grey font-weight-bold h-auto py-4 rounded-0" id="product">
              <option value="">{{ __('custom.select_nft_products') }}</option>
              @foreach($withdrawncollections as $value)
              <option value="{{$value->product_id}}" data-value="{{$value->id}}">{{$value->nftproduct->name}}</option>
              @endforeach
            </select>
            <input type="hidden" name="nft_id" value="" id="nft_id"> 
          </div>
          <div class="col-12 col-md-6 mt-4 mt-md-0">
            <input type="password" name="secure_password" class="form-control grey-ph h-auto py-4 border-0 shadow" placeholder="{{ trans('custom.security_password')}}">
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12 col-md-6 mt-4 mt-md-0">
            {{--  @if($user->usdt_address == '' || $user->usdt_address == null) --}}
            {{Form::text('nft_address',old('nft_address'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.nft_wallet_address')])}}
            {{--  @else
            {{Form::text('usdt_address',$user->usdt_address,['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.USDT_address'), 'readonly' => 'true'])}}
            @endif --}}
          </div>
          <div class="col-12 col-md-6 mt-4 mt-md-0">
            {{-- @if($user->usdt_address == '' || $user->usdt_address == null || $user->usdt_image == '')--}}
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
            {{-- @else

            <img width="auto" height="100px" src="{{asset('/uploads/withdrawl_request/'.$user->usdt_image)}}" class="img-responsive">
            @endif  --}}
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
<div class="row mt-5">
  <div class="col-12">
    <p class="text-white pb-3">{{ trans('custom.withdrawal_history')}}</p>
  </div>
  <div class="col-12">
    <div class="table-history">
      @include('profile/nftwithdrawlwalletajax')
    </div>
  </div>
</div>
@endsection