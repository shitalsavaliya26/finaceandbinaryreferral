@extends('layouts.app')
@section('title', __('custom.staking_pools'))
@section('page_title', __('custom.staking_pools'))
@section('content')
<div class="staking-main content-wrapper">
    <div class="ml-2 mb-4 d-none-desk d-md-block">
        <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
        @if (Route::currentRouteName() == 'dashboard')
        <p class="text-white">{{ str_replace('#name', auth()->user()->name, __('custom.wc_text')) }}</p>
        @endif
    </div>
    <div class="row ml-1 mr-1">
        <?php $i = 1;
        $j = 1; ?>
        <div class="row">
            @foreach ($staking_pool as $stackingpool)
            @if ($i == 1)
            <div class="col-12 col-md-3 mt-5">
                <div class="bg-card-4 text-center p-4 rounded">
                    <img src="{{ $stackingpool->symbol }}" class="img-fluid alpha-top-img stk-logo" alt="">
                    <h4 class="text-blue font-weight-bold">{{ $stackingpool->name }}</h4>
                    <p class="border-top border-blue mt-3 mx-auto"></p>
                    <p class="text-secondary ear font-12">{{ __('custom.expected_anual_rate') }}</p>
                    <h3 class="text-blue font-weight-bold">{{ $stackingpool->stacking_display_start }}% -
                        {{ $stackingpool->stacking_display_end }}%</h3>
                        <div><img class="stake-logo" src="{{ $stackingpool->image }}"
                            class="img-fluid alpha-bottom-img mt-4" alt="" style="max-width: 100%;">
                        </div>
                        @if ($stackingpool->investedAmount > 0)
                        <div class="d-flex justify-content-around mt-2">
                            <p class="text-dark inva font-weight-bold font-14">{!! __('custom.invested_amount') !!}</p>
                            <button
                            class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stackingpool->investedAmount, 2) }}</button>
                        </div>
                        <a class="btn bg-warning text-white px-3 rounded-0 font-10 mt-2"
                        href="{{ route('stakepool', $stackingpool->id) }}">{{ __('custom.stake') }} <img
                        src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                        class="img-fluid ml-2 d-inline align-middle w-25" alt="">
                    </a>
                    @else
                    <a class="btn bg-warning text-white px-3 rounded-0 font-10 mt-2"
                    href="{{ route('stakepool', $stackingpool->id) }}">{{ __('custom.stake') }} <img
                    src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                    class="img-fluid ml-2 d-inline align-middle" alt=""></a>

                    @endif
                </div>
            </div>
                        
      @elseif($i == 2)
      <div class="col-12 col-md-3 mt-5">
        <div class="bg-card-2 text-center p-4 rounded">
            <img src="{{ $stackingpool->symbol }}" class="img-fluid alpha-top-img stk-logo" alt="">
            <h4 class="text-white font-weight-bold">{{ $stackingpool->name }}</h4>
            <p class="border-top border-white mt-3 mx-auto"></p>
            <p class="text-white ear font-12">{{ __('custom.expected_anual_rate') }}</p>
            <h3 class="text-blue font-weight-bold">{{ $stackingpool->stacking_display_start }}% -
                {{ $stackingpool->stacking_display_end }}%</h3>
                <div><img class="stake-logo" src="{{ $stackingpool->image }}"
                    class="img-fluid alpha-bottom-img mt-4" alt="" style="max-width: 100%;">
                </div>
                @if ($stackingpool->investedAmount > 0)
                <div class="d-flex justify-content-around mt-2">
                    <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                    <button
                    class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stackingpool->investedAmount, 2) }}</button>
                </div>
                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                href="{{ route('stakepool', $stackingpool->id) }}">{{ __('custom.stake') }} <img
                src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a>
                @else
                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                href="{{ route('stakepool', $stackingpool->id) }}">{{ __('custom.stake') }} <img
                src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                @endif
            </div>
        </div>
                        
      @elseif($i == 3)
      <div class="col-12 col-md-3 mt-5">
        <div class="bg-card-3 text-center p-4 rounded">
            <img src="{{ $stackingpool->symbol }}" class="img-fluid alpha-top-img stk-logo" alt="">
            <h4 class="text-white font-weight-bold">{{ $stackingpool->name }}</h4>
            <p class="border-top border-white mt-3 mx-auto"></p>
            <p class="text-white ear font-12">{{ __('custom.expected_anual_rate') }}</p>
            <h3 class="text-blue font-weight-bold">{{ $stackingpool->stacking_display_start }}% -
                {{ $stackingpool->stacking_display_end }}%</h3>
                <div><img class="stake-logo" src="{{ $stackingpool->image }}"
                    class="img-fluid alpha-bottom-img mt-4" alt="" style="max-width: 100%;">
                </div>
                @if ($stackingpool->investedAmount > 0)
                <div class="d-flex justify-content-around mt-2">
                    <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                    <button
                    class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stackingpool->investedAmount, 2) }}</button>
                </div>
                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                href="{{ route('stakepool', $stackingpool->id) }}">{{ __('custom.stake') }} <img
                src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a>
                @else
                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                href="{{ route('stakepool', $stackingpool->id) }}">{{ __('custom.stake') }} <img
                src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                @endif
            </div>
        </div>
                    
      @elseif($i == 4)
      <div class="col-12 col-md-3 mt-5">
        <div class="bg-card-1 text-center p-4 rounded">
            <img src="{{ $stackingpool->symbol }}" class="img-fluid alpha-top-img stk-logo" alt="">
            <h4 class="text-white font-weight-bold">{{ $stackingpool->name }}</h4>
            <p class="border-top border-white mt-3 mx-auto"></p>
            <p class="text-white ear font-12">{{ __('custom.expected_anual_rate') }}</p>
            <h3 class="text-blue font-weight-bold">{{ $stackingpool->stacking_display_start }}% -
                {{ $stackingpool->stacking_display_end }}%</h3>
                <div><img class="stake-logo" src="{{ $stackingpool->image }}"
                    class="img-fluid alpha-bottom-img mt-4" alt="" style="max-width: 100%;">
                </div>
                @if ($stackingpool->investedAmount > 0)
                <div class="d-flex justify-content-around mt-2">
                    <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                    <button
                    class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stackingpool->investedAmount, 2) }}</button>
                </div>
                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                href="{{ route('stakepool', $stackingpool->id) }}">{{ __('custom.stake') }} <img
                src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a>
                @else
                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                href="{{ route('stakepool', $stackingpool->id) }}">{{ __('custom.stake') }} <img
                src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                @endif
            </div>
        </div>
        
      @endif
      <?php
      $i++;
      $j++;
      if ($i == 5) {
        $i = 1;
    }
    ?>

    @endforeach
      
  </div>
  @endsection
