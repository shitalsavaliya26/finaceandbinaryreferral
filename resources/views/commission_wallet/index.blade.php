@extends('layouts.app')
@section('title', __('custom.commission_wallet'))
@section('page_title', __('custom.commission_wallet'))
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
				<h2 class="mb-0 font-weight-bold">${{ number_format($userWallet->commission_wallet, 2) }}</h2>
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
						{!! trans('custom.commission_wallet_terms_and_conditions1') !!}
					</div>
					<div class="col-12 col-md-6 col-xl-4">
						{!! trans('custom.commission_wallet_terms_and_conditions2') !!}
					</div>
					<div class="col-12 col-md-6 col-xl-4">
						{!! trans('custom.commission_wallet_terms_and_conditions3') !!}
					</div>
					</div>
					{{Form::open(['route' => 'commission-wallet-store','class' => 'confirm-submit','id' =>'commission-wallet-confirm','enctype' => 'multipart/form-data'])}}
					<div class="row mt-4">
						<div class="col-12 col-md-4">
							{{Form::select('fund_type',['0'=> trans('custom.crypto_wallet'),'1'=> trans('custom.withdrawal_wallet'), '2'=> trans('custom.nft_wallet')],old('type'),['class' => 'form-control text-grey font-weight-bold h-auto py-4 border-0 outline-0 shadow','placeholder' => trans('custom.fund_type_placeholder')])}}
						</div>
						<div class="col-12 col-md-4 mt-4 mt-md-0">
							{{Form::number('amount',old('amount'),['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.amount'), 'autocomplete' => 'off'])}}
						</div>
						<div class="col-12 col-md-4 mt-4 mt-md-0">
							{{Form::password('secure_password',['class' => 'form-control grey-ph h-auto py-4 border-0 shadow','placeholder' => trans('custom.security_password')])}}
						</div>
						<div class="col-12 col-xl-6 mt-4">
							<button class="btn bg-warning text-white py-4 px-5 rounded-0">{{ trans('custom.transfer_fund')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-4 d-inline align-middle" alt=""></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="table-responsive table-history">
		@include('commission_wallet.history')
	</div>
	@endsection