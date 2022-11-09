@extends('layouts.app')
@section('title', __('custom.nft_marketplace'))
@section('page_title', __('custom.nft_marketplace'))
@section('content')
 <div class="content-wrapper nft-market">
     <div class="ml-2 mb-4 d-none-desk d-md-block">
      <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
      @if(Route::currentRouteName() == 'dashboard')
      <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
      @endif
    </div>
          <div class="row mt-1">
            @foreach($nft_cats as $category)
            <div class="col-12 col-md-6 col-lg-4 mt-3">
              <div class="bg-bullkong rounded d-flex flex-column align-items-center justify-content-end text-white categorysection" style="background-image:url({{$category->image}})" id="{{$category->id}}">
                  <div class="title-bg-nft rounded">
                <h2 class="mb-0">{{$category->name}}</h2>
                <h4 class="mb-3">{{ trans('custom.collection')}}</h4>
                      </div>
              </div>
            </div>
            @endforeach
          </div>
          @foreach($nft_cats as $category)
          <div class="row mt-5" id="productsection{{$category->id}}">
            <div class="col-12 mt-3 mb-2">
                <h3 class="text-white">{{ $category->name}} {{ trans('custom.collection')}}</h3>
            </div>
            <div class="col-12">
              <div class="bull-kong-slider">
                @forelse ($category->product as $product)
                    <div>
                      {{-- <a class="min-h-240 bg-white p-3 rounded mx-2 d-block text-decoration-none"  href="{{route('nftproduct', $product->id)}}"> --}}
                        {{-- <img src="{{ asset('uploads/nft-product/'.$product->image) }}" class="img-fluid mx-auto" alt=""> --}}
                      @if ($product->product_status == "Sold" || $product->is_reserved == 1)
                      <a href="{{route('nftproduct', $product->id)}}" class="min-h-240 bg-white p-3 rounded mx-2 d-block text-decoration-none">
                          <div class="position-relative overflow-hidden">
                            <img src="{{ asset($product->image) }}" class="img-fluid w-100" alt="">
                            <span class="sale-label">SOLD</span>
                          </div>
                      @else
                      <a class="min-h-240 bg-white p-3 rounded mx-2 d-block text-decoration-none"  href="{{route('nftproduct', $product->id)}}">
                           <img src="{{ asset($product->image) }}" class="img-fluid mx-auto" alt="">
                      @endif
                        <div class="mt-3">
                          <h4 class="text-blue font-weight-bold">{{ $product->name }}</h4>
                          <h3 class="text-black font-weight-bold">${{ number_format($product->price, 2) }}</h3>
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
          @endforeach
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).on("click", ".categorysection", function() {
            var categoryid = $(this).attr('id');
            $('html,body').animate({scrollTop: $("#productsection"+categoryid).offset().top},
        'slow');
    });
</script>
@endsection