@extends('layouts.app')
@section('title', __('custom.nft_marketplace'))
@section('page_title', __('custom.nft_marketplace'))
@section('content')
<div class="content-wrapper indi-nft">
    <div class="ml-2 mb-4 d-none-desk d-md-block">
      <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
      @if(Route::currentRouteName() == 'dashboard')
      <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
      @endif
    </div>
	<div class="row align-items-center mt-3">
		<div class="col-12 col-md-6">
			@if ($product->product_status == "Sold")
			<div class="position-relative overflow-hidden">
				<img src="{{ asset($product->image) }}" class="img-fluid w-100" alt="">
				<span class="sale-label">SOLD</span>
			</div>
			@else
			<img src="{{ asset($product->image) }}" class="img-fluid" alt="">
			@endif
			{{-- <img src="{{ asset('uploads/nft-product/'.$product->image) }}" class="img-fluid" alt=""> --}}
		</div>
		<div class="col-12 col-md-6 text-white mt-4 mt-md-0">
			@if(Session::has('success'))
			<div class="alert alert-success alert-dismissable">
				{{ Session::get('success') }}
			</div>
			@endif

			@if(Session::has('error'))
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				{{ Session::get('error') }}
			</div>
			@endif
			
			<h2>{{ $product->name }}</h2>
			<p class="font-12 w-75 mt-3">{{ $product->description }}</p>
			<h2 class="mt-3 nft-price">$ {{ $product->price }}</h2>
			
			@if ($product->product_status != "Sold")
			@if(!$checkProduct)
			<form method="post" action="{{ route('purchase-product') }}" id="purchase_product">
				@csrf
				<div class="row justfy-content-between align-items-center mt-4">
					<div class="col-12 col-xl-8">
						<input type="hidden" name="product_id" value="{{ $product->id }}">
						<input type="hidden" name="amount" value="{{ $product->price }}">
						<input type="hidden" name="name" id="name" value="{{ $product->name }}">

						<input name="security_password" id="security_password" type="password" class="form-control h-auto py-4" placeholder="{{ trans('custom.security_password') }}">
						@error('secure_password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="col-12 col-xl-4 mt-4 mt-lg-0">
						<button type="submit" class="btn bg-warning text-white p-4 rounded-0">{{ trans('custom.buy_now')}} <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}" class="img-fluid ml-2 d-inline align-middle w-25" alt=""></button>
					</div>
				</div>
			</form>			
			@else
			<div class="row justfy-content-between align-items-center mt-4">
				<div class="col-12 col-xl-8">
					<strong class="text-success">@if($checkProduct && $checkProduct->user_id == auth()->user()->id) {{ __('custom.product_owned_by_you') }} @else {{ str_replace('#username', $checkProduct->user_detail->username, __('custom.product_owned_by_username')) }} @endif</strong>
				</div>
			</div>
			@endif
			@else
			<div class="row justfy-content-between align-items-center mt-4">
				<div class="col-12 col-xl-8">
					<strong class="text-danger">{{ __('custom.sold') }}</strong>
				</div>
			</div>
			@endif
			<p class="border-top border-white mt-4"></p>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-12 col-md-6">
            <h4 class="text-white pb-3">{{ trans('custom.trading_history')}}</h4>
			<div class="table-responsive table-history">
				@include('nft_marketplace.nft_purchase_history')
			</div>
		</div>
		<div class="col-12 col-md-6 mt-4 mt-md-0">
			<h4 class=" text-white">{{ trans('custom.nft_terms')}}</h4>
			{!!__('custom.nft_marketplace_tc')!!}
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-12">
			{{-- <p class="text-white pb-3">{{ __('custom.other_collection')}}</p> --}}
			<h4 class="text-white pb-3">Other {{ $collectionname->name ?? '' }} Collection</h4>
		</div>
		<div class="col-12">
			<div class="bull-kong-slider">
				@forelse($othrt_products as $value)
				<div>
					<a href="{{route('nftproduct', $value->id)}}" class="text-decoration-none">
						<div class="bg-white p-3 rounded mx-2">
							@if ($value->product_status == "Sold")
							<div class="position-relative overflow-hidden">
								<img src="{{ asset($value->image) }}" class="img-fluid w-100" alt="">
								<span class="sale-label">SOLD</span>
							</div>
							@else
							<img src="{{ asset($value->image) }}" class="img-fluid mx-auto" alt="">
							@endif
							<div class="mt-3">
								<h4 class="text-blue font-weight-bold">{{ $value->name }}</h4>
							</div>
						</div>
					</a>
				</div>
				@empty
				<ul>
					<li class="text-white mx-2">{{ trans('custom.no_products_available') }}</li>
				</ul> 
				@endforelse
			</div>
		</div>
	</div>
	@endsection
	@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('.nav-item').removeClass('active');
			$('.collapse').removeClass('show');
			$('.nftproduct').addClass('active');

		})
	</script>
	@endsection