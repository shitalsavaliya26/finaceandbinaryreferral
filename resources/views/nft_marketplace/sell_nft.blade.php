@extends('layouts.app')
@section('title', __('custom.sell_nft'))
@section('page_title', __('custom.sell_nft'))
@section('content')
    <div class="content-wrapper">
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

      @if ($errors->any())
      <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
      @endif
        <div class="row mt-5 pt-5">
            @if (count($collections) > 0)
                @foreach ($collections as $value)
                    <div class="col-12 col-md-6 col-xl-3 mt-3" onclick="showNFTSell({{ $value->id }})">
                        <div class="bg-white p-3 rounded mx-2" data-toggle="modal" @if ($value->status != 2) data-target="#bullKongModal{{ $value->product_id }}" @endif>
                          {{-- <div class="bg-white p-3 rounded mx-2" data-toggle="modal" @if ($value->type != 1) data-target="#bullKongModal{{ $value->product_id }}" @endif> --}}
                      {{-- <div class="bg-white p-3 rounded mx-2" data-toggle="modal" data-target="#bullKongModal{{ $value->product_id }}">   --}}
                            <div class="position-relative overflow-hidden">
                                <img src="{{ asset($value->nftproduct->image) }}"
                                    class="img-fluid w-100" alt="">
                                @if ($value->status == 2)
                                    <span class="sale-label">{{ __('custom.on_sale') }}</span>
                                @endif
                            </div>
                            <div class="mt-3">
                                <h4 class="text-blue font-weight-bold">{{ $value->nftproduct->name }}</h4>
                                <h3 class="text-black font-weight-bold">${{ $value->amount }}</h3>
                                <span class="text-secondary">{{ date('d/m/Y', strtotime($value->created_at)) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
              <div class="col-12">
                <p class="text-white font-weight-bold">{{ __('custom.no_collection_found')}}</p>
              </div>
            @endif
        </div>
        <div id="nftmodel"><div>
        <div id="countdownmodelshow"><div>
        <div class="row mt-5">
            <div class="col-12">
                <div>
                    <p class="text-white pb-3">Sale History</p>
                </div>
                <div class="table-history">
                @include('nft_marketplace.sale_history')
                </div>
            </div>
        </div>
    @endsection
    
