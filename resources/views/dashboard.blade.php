@extends('layouts.app')

@section('content')
<div class="content-wrapper dashboard">
    <div class="mb-4 d-none-desk d-md-block dashtop">
        <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
        @if (Route::currentRouteName() == 'dashboard')
        <p class="text-white">{{ str_replace('#name', auth()->user()->name, __('custom.wc_text')) }}</p>
        @endif
    </div>
    <div class="row mt-3 pt-0">
        <div class="col-12 col-xl-12">

            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                {{ Session::get('success') }}
            </div>
            @endif

            @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {{ Session::get('error') }}
            </div>
            @endif
        </div>
        <div class="col-12 col-xl-4 stretch-card profileb">
            <div class="card tale-bg overflow-hidden bg-white pb-3">
                <div class="bg-warning p-4 pb-5">
                    <h3 class="text-white pb-2">{{ __('custom.my_profile') }}</h3>
                </div>
                <div class="px-4 cus-my-profile-img">
                    <img src="{{ $user->profile_image }}" class="rounded-circle img-fluid" alt="">
                </div>
                <div class="row px-4 mt-4">
                    <div class="col-md-6">
                        <h3 class="text-dark font-weight-bold mb-0">{{ $user->name }}</h3>
                        <span class="text-secondary font-12">{{ trans('custom.full_name') }}</span>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-black mb-0 font-weight-bold">${{ $total_stacking ?? '0'}}</h3>
                        <span class="text-secondary font-10">{{trans('custom.total_staking')}}</span>
                    </div>
                        <!--  <div class="col-md-6">
                  <h4 class="text-dark font-weight-bold mb-0">{{ $user->rank ? $user->rank->name : '-' }}</h4>
                  <span class="text-secondary font-12">{{ trans('custom.current_rank') }}</span>
              </div> -->
          </div>
          <div class="row px-4 mt-4">
            <div class="col-md-6">
                <h4 class="text-secondary mb-0" style="font-size: 15px">{{ $user->email }}</h4>
                <span class="text-secondary font-12">{{ trans('custom.email') }}</span>
            </div>
            <div class="col-md-6">
                <h4 class="text-secondary mb-0">{{ $user->phone_number }}</h4>
                <span class="text-secondary font-12">{{ trans('custom.phone_number') }}</span>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-xl-8">
    <div class="dashboard-slider">
        @if ((new \Jenssegers\Agent\Agent())->isDesktop())
        @foreach ($sliders as $slider)
        <div class="position-relative">
            <img src="{{ $slider->image }}" class="img-fluid min-height-280" alt="">
            <div class="text-center text-white NFT-collection">
                                    <!-- <h4>LAUNCHING SOON</h4>
                                      <h3>NFT COLLECTIONS</h3> -->
                                      {{-- <button class="btn bg-transparent text-warning border-warning px-3 rounded-0 font-10 mt-2">{{__('custom.explore')}} <img src="{{ $slider->url }}" class="img-fluid ml-2 d-inline align-middle" alt=""></button> --}}
                                  </div>
                              </div>
                              @endforeach
                              @else
                              @foreach ($sliders as $slider)
                              <div class="position-relative">
                                <img src="{{ $slider->mobile_image }}" class="img-fluid min-height-280" alt="">
                                <div class="text-center text-white NFT-collection">
                                    <!-- <h4>LAUNCHING SOON</h4>
                                      <h3>NFT COLLECTIONS</h3> -->
                                      {{-- <button class="btn bg-transparent text-warning border-warning px-3 rounded-0 font-10 mt-2">{{__('custom.explore')}} <img src="{{ $slider->url }}" class="img-fluid ml-2 d-inline align-middle" alt=""></button> --}}
                                  </div>
                              </div>
                              @endforeach
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="text-white">
                        {{ __('custom.staking_network_pools') }}</h3>
                    </div>
                    <div class="col-12 stack-row">
                        <div class="stacking-slider">
                            <?php $i = 1; ?>
                            @foreach ($staking_pool as $stakingpool)
                            @if ($i == 1)
                            <div>
                                <div class="bg-card-{{ $i }} text-center p-4 pb-3 rounded mx-2 position-relative">
                                    <img class="stake-logo" src="{{ $stakingpool->symbol }}"
                                    class="img-fluid card-img-top" alt="">

                                    <h4 class="text-white">{{ $stakingpool->name }}</h4>
                                    {{-- <p class="text-white font-12">{!! \Illuminate\Support\Str::limit($stakingpool->description,50) !!}</p> --}}
                                    <hr />
                                    <p class="text-white font-14">{{ __('custom.expected_anual_rate') }}</p>
                                    <h3 class="text-white font-weight-bold">{{ $stakingpool->stacking_display_start }}% -
                                        {{ $stakingpool->stacking_display_end }}%</h3>
                                        <img class="stake-tokens-logo my-3" src="{{ $stakingpool->image }}"
                                        style="max-width: 100%;" />
                                        @if ($stakingpool->investedAmount > 0)

                                        {{-- <div class="d-flex justify-content-around mt-2">
                                            <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                                            <button
                                            class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                                        </div>
                                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-1-btn position-absolute"
                                        href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}
                                        <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                        class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a> --}}

                                    <div class="d-flex justify-content-around mt-2 mb-4">
                                        <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                                        <button class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                                        </div>
                                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}  <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                        class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                                        @else
                                        <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                                        href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}
                                        <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                        class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    @elseif($i == 2)
                                    <div class="bg-card-2 text-center p-4 pb-3 rounded mx-2 position-relative">
                                        <img class="stake-logo" src="{{ $stakingpool->symbol }}"
                                        class="img-fluid card-img-top" alt="">
                                        <h4 class="text-white">{{ $stakingpool->name }}</h4>
                                        {{-- <p class="text-white font-12">{!! \Illuminate\Support\Str::limit($stakingpool->description,50) !!}</p> --}}
                                        <hr />
                                        <p class="text-white font-14">{{ __('custom.expected_anual_rate') }}</p>
                                        <h3 class="text-white font-weight-bold">{{ $stakingpool->stacking_display_start }}% -
                                            {{ $stakingpool->stacking_display_end }}%</h3>
                                            <img class="stake-tokens-logo my-3" src="{{ $stakingpool->image }}"
                                            style="max-width: 100%;" />
                                            @if ($stakingpool->investedAmount > 0)
                                            {{-- <div class="d-flex justify-content-around mt-2">
                                                <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                                                <button
                                                class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                                            </div>
                                            <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-2-btn position-absolute"
                                            href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}
                                            <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                            class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a> --}}

                                        <div class="d-flex justify-content-around mt-2 mb-4">
                                            <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                                            <button class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                                            </div>
                                            <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}  <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                            class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                                            @else
                                            <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                                            href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}
                                            <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                            class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        @elseif($i == 3)
                                        <div class="bg-card-3 text-center p-4 pb-3 rounded mx-2 position-relative">
                                            <img class="stake-logo" src="{{ $stakingpool->symbol }}"
                                            class="img-fluid card-img-top">
                                            <h4 class="text-white">{{ $stakingpool->name }}</h4>
                                            {{-- <p class="font-12 text-white">{!! \Illuminate\Support\Str::limit($stakingpool->description,50) !!}</p> --}}
                                            <hr />
                                            <p class="text-white font-14">{{ __('custom.expected_anual_rate') }}</p>
                                            <h3 class="text-white font-weight-bold">{{ $stakingpool->stacking_display_start }}% -
                                                {{ $stakingpool->stacking_display_end }}%</h3>
                                                <img class="stake-tokens-logo my-3" src="{{ $stakingpool->image }}"
                                                style="max-width: 100%;" />
                                                @if ($stakingpool->investedAmount > 0)
                                                {{-- <div class="d-flex justify-content-around mt-2">
                                                    <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                                                    <button
                                                    class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                                                </div>
                                                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-3-btn position-absolute"
                                                href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}
                                                <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                                class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a> --}}

                                            <div class="d-flex justify-content-around mt-2 mb-4">
                                                <p class="text-white font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                                                <button class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                                                </div>
                                                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}  <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                                class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                                                @else
                                                <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2"
                                                href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}
                                                <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                                class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                                                @endif
                                            </div>
                                        </div>
                                        @elseif($i == 4)
                                        <div>
                                            <div class="bg-card-4 text-center p-4 pb-3 rounded mx-2 position-relative">
                                                <img class="stake-logo" src="{{ $stakingpool->symbol }}"
                                                class="img-fluid card-img-top">
                                                <h4>{{ $stakingpool->name }}</h4>
                                                {{-- <p class="font-12">{!! \Illuminate\Support\Str::limit($stakingpool->description,50) !!}</p> --}}
                                                <hr />
                                                <p class="text-blue font-14">{{ __('custom.expected_anual_rate') }}</p>
                                                <h3 class="text-blue font-weight-bold">{{ $stakingpool->stacking_display_start }}% -
                                                    {{ $stakingpool->stacking_display_end }}%</h3>
                                                    <img class="stake-tokens-logo my-3" src="{{ $stakingpool->image }}"
                                                    style="max-width: 100%;" />
                                                    @if ($stakingpool->investedAmount > 0)
                                                    {{-- <div class="d-flex justify-content-around mt-2">
                                                        <p class="text-dark font-weight-bold font-12">{!! __('custom.invested_amount') !!}</p>
                                                        <button
                                                        class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</button>
                                                    </div>
                                                    <a class="btn bg-warning text-white px-3 rounded-0 font-10 mt-2 card-4-btn"
                                                    href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}
                                                    <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                                    class="img-fluid ml-2 d-inline align-middle w-25" alt=""></a> --}}

                                                <div class="d-flex justify-content-around mt-2 mb-4">
                                                    <p class="text-white font-weight-bold font-14">{!! __('custom.invested_amount') !!}</p>
                                                    <div class="btn bg-blue text-white rounded-0 px-4">${{ number_format($stakingpool->investedAmount, 2) }}</div>
                                                    </div>
                                                    <a class="btn bg-white text-warning px-3 rounded-0 font-10 mt-2 card-4-btn" href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}  <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                                    class="img-fluid ml-2 d-inline align-middle" alt=""></a>
                                                    @else
                                                    <a class="btn bg-warning text-white px-3 rounded-0 font-10 mt-2"
                                                    href="{{ route('stakepool', $stakingpool->id) }}">{{ __('custom.stake') }}
                                                    <img src="{{ asset('assets/images/assets/Dashboard/Group930.png') }}"
                                                    class="img-fluid ml-2 d-inline align-middle" alt=""></a>

                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            <?php
                                            $i++;
                                            if ($i == 5) {
                                                $i = 1;
                                            }
                                            ?>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 nftrow">
                                     <div class="col-12">
                                        <h3 class="text-white">
                                        {{ __('custom.last_nfts') }}</h3>
                                    </div>
                                    <div class="col-12">
                                        <div class="stacking-slider">
                                            @foreach ($nft_cats as $category)
                                            <div>
                                                <div class="mx-2">
                                                    <a href="{{ route('nft_marketplace') }}#productsection{{ $category->id }}"
                                                        class="bg-bullkong rounded d-flex align-items-end text-white text-decoration-none"
                                                        style="background-image:url({{ $category->image }})">
                                                        <h3 class="px-4 pt-5 pb-3">{{ $category->name }}</h3>
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
            <!--   <div class="col-12 col-md-6 col-lg-4">
        <div class="bg-bullkong rounded d-flex align-items-end px-4 py-3 text-white" style="background-image:url(test/uploads/nft-category/1636783527_nft_category.jpg)">
          <h3>The Legends</h3>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="bg-bullkong rounded d-flex align-items-end px-4 py-3 text-white" style="background-image:url(test/public/assets/images/assets/nft/car-2.gif)">
          <h3>Cyber Autos</h3>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="bg-bullkong rounded d-flex align-items-end px-4 py-3 text-white" style="background-image:url(test/public/assets/images/assets/nft/Number-8.gif)">
          <h3>Lucky Numbers</h3>
        </div>

      </div> ->
            <div class="bg-bullkong rounded d-flex align-items-end px-4 py-3 text-white" style="background-image:url(test/uploads/nft-category/1636783527_nft_category.jpg)">
              <h3>The Legends</h3>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="bg-bullkong rounded d-flex align-items-end px-4 py-3 text-white" style="background-image:url(test/public/assets/images/assets/nft/car-2.gif)">
              <h3>Cyber Autos</h3>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="bg-bullkong rounded d-flex align-items-end px-4 py-3 text-white" style="background-image:url(test/public/assets/images/assets/nft/Number-8.gif)">
              <h3>Lucky Numbers</h3>
            </div>
        </div> -->
    </div>
    <div class="row mt-5 earnb">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-12">
                    <h4 class="text-grey">{{ __('custom.earning_breakdown') }}</h4></div></div>
                    <div class="row pt-4">
                        <div class="col-12 col-md-4">
                           <h4 class="font-weight-bold text-pink mb-0">
                                ${{ $user->userwallet ? number_format($user->userwallet->roi, 2) : '' }}</h4>
                            <p>{{ __('custom.apr_monthly') }}</p>
                        </div>
                        <div class="col-12 col-md-4">
                            <h4 class="font-weight-bold text-violate mb-0">
                                ${{ $user->userwallet ? number_format($user->userwallet->referral_commission, 2) : '' }}
                            </h4><p>{{ __('custom.direct_refferal') }}</p>
                        </div>
                        <div class="col-12 col-md-4">
                        <h4 class="font-weight-bold text-success mb-0">
                            ${{ $user->userwallet ? number_format($user->userwallet->pairing_commission, 2) : '' }}
                        </h4>
                                <p>{{ __('custom.balancing_commission') }}</p>
                    
                        </div>
                <div class="col-12 mt-4">
                    <div class="" id="hightlinechart" class="img-fluid rounded-right w-100"
                    alt="" style="height: 336px;"></div>
                    <!-- <img src="{{ asset('assets/images/assets/Dashboard/Group1052.png') }}" class="img-fluid h-350" alt="logo"/> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body p-4">
            <div class="row pt-2">
                <div class="col-12 col-md-6">
                    <h4 class="text-grey">{{ __('custom.commission_breakdown') }}</h4>
                </div>
                <div class="col-12 col-md-6 text-md-right">
                    <select name="grphfilter"
                    class="rounded-0 font-weight-bold border-violate font-12 p-2 px-3 grphfilter">
                    <option value="{{ \Carbon\Carbon::now()->format('m') }}">
                    {{ __('custom.this_month') }}</option>
                    <option value="{{ \Carbon\Carbon::now()->subMonth()->format('m') }}">
                    {{ __('custom.last_month') }}</option>

                </select>
            </div>
            <div class="col-12 text-center mt-3">
                <div id="commissionpiechart" class="img-fluid rounded-right w-100" alt=""
                style="height: 336px;">{{ trans('custom.no_data_found') }}</div>
                <!-- <img src="{{ asset('assets/images/assets/Dashboard/Group1056.png') }}" class="img-fluid" alt="logo"/> -->
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 col-md-4 text-center mt-3">
                <p class="d-flex align-items-center justify-content-center mb-0 text-grey"><span
                    class="count bg-pink d-block mr-2"></span>{{ __('custom.apr_monthly') }}</p>
                    <h4 class="text-black font-weight-bold mt-2"><span id="apr_monthly">
                        ${{ number_format($commissionData[\Carbon\Carbon::now()->format('m')]['apr_monthly'][1], 2) }}</span>
                    </h4>
                </div>
                <div class="col-12 col-md-4 text-center mt-3">
                    <p class="d-flex align-items-center justify-content-center mb-0 text-grey"><span
                        class="count bg-violate d-block mr-2"></span>{{ __('custom.direct_refferal') }}
                    </p>
                    <h4 class="text-black font-weight-bold mt-2"><span id="referral_commission">
                        ${{ number_format($commissionData[\Carbon\Carbon::now()->format('m')]['referral_commission'][1], 2) }}</span>
                    </h4>
                </div>
                <div class="col-12 col-md-4 text-center mt-3">
                    <p class="d-flex align-items-center justify-content-center mb-0 text-grey"><span
                        class="count bg-success d-block mr-2"></span>{{ __('custom.balancing_commission') }}
                    </p>
                    <h4 class="text-black font-weight-bold mt-2">
                        <span
                        id="balancing_commission">${{ number_format($commissionData[\Carbon\Carbon::now()->format('m')]['balancing_commission'][1], 2) }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row mb-5 wallets-dash">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card bg-crypto-wallet">
                    <div class="card-body text-white">
                        <h4 class="mb-4">{{ __('custom.crypto_wallet') }} </h4>
                        <h3 class="fs-30 mb-2">
                            ${{ $user->userwallet ? number_format($user->userwallet->crypto_wallet, 2) : '' }}</h3>
                            <h5 class="font-12">{{ __('custom.balance') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3 mt-4 mt-md-0">
                    <div class="card bg-yield-wallet">
                        <div class="card-body text-white">
                            <h4 class="mb-4">{{ __('custom.yield_wallet') }} </h4>
                            <h3 class="fs-30 mb-2">
                                ${{ $user->userwallet ? number_format($user->userwallet->yield_wallet, 2) : '' }}</h3>
                                <h5 class="font-12">{{ __('custom.balance') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3 mt-4 mt-xl-0">
                        <div class="card bg-commission-wallet">
                            <div class="card-body text-white">
                                <h4 class="mb-4">{{ __('custom.commission_wallet') }} </h4>
                                <h3 class="fs-30 mb-2">
                                    ${{ $user->userwallet ? number_format($user->userwallet->commission_wallet, 2) : '' }}
                                </h3>
                                <h5 class="font-12">{{ __('custom.balance') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3 mt-4 mt-xl-0">
                        <div class="card bg-NFT-wallet">
                            <div class="card-body text-white">
                                <h4 class="mb-4">{{ __('custom.nft_wallet') }} </h4>
                                <h3 class="fs-30 mb-2">
                                    ${{ $user->userwallet ? number_format($user->userwallet->nft_wallet, 2) : '' }}</h3>
                                    <h5 class="font-12">{{ __('custom.balance') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(auth()->user()->staking_history->count() > 0 )
            <div class="row dashboard-news">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row p-3">
                                <div class="col-12 pb-4">
                                    <h3>{{ __('custom.news-events') }}</h3>
                                </div>
                                @if ($news != null)
                                @foreach ($news as $key => $value)
                                @if ($key == 0)
                                <div class="col-12 col-xl-7">
                                  <a href="{{ route('news-and-events.show', $value->id) }}">
                                      <div class="bg-news p-4 d-flex flex-column justify-content-end"
                                      style="background-image: url({{ $value->image }});">    
                                  </div>
                              </a>

                              <div class="pt-3">
                                  <h3><a class="text-decoration-none text-dark"
                                      href="{{ route('news-and-events.show', $value->id) }}">{!! \Illuminate\Support\Str::limit($value->title, 50) !!}</a>
                                  </h3>
                                  <p class="font-14"><a class="text-decoration-none text-dark"
                                      href="{{ route('news-and-events.show', $value->id) }}">{!! \Illuminate\Support\Str::limit($value->details, 200) !!}</a></p>
                                  </div>
                              </div>
                              @else
                              @if ($key == 1)
                              <div class="col-12 col-xl-5 mt-4 mt-xl-0">
                                @endif
                                <div class="d-flex align-items-center {{ $key > 1 ? 'mt-3' : '' }}">
                                  <div class="newsimg col-xl-6 p-0">
                                      <a href="{{ route('news-and-events.show', $value->id) }}"><img src="{{ $value->image }}" class="img-fluid" alt=""></a>
                                  </div>
                                  <div class="ml-3 border-bottom pb-3">
                                      <h5 class="mb-2"><a class="text-dark text-decoration-none"
                                          href="{{ route('news-and-events.show', $value->id) }}">{!! \Illuminate\Support\Str::limit($value->title, 50) !!}</a>
                                      </h5>
                                      <p class="font-weight-bold"><a class="text-dark text-decoration-none"
                                          href="{{ route('news-and-events.show', $value->id) }}">{!! \Illuminate\Support\Str::limit($value->details, 50) !!}</a></p>
                                      </div>
                                  </div>
                  @if ($key == count($news) - 1)
              </div>
              @endif
              @endif
              @endforeach
              @endif
          </div>
      </div>
  </div>
</div>
</div>
@endif

@if($user->userwallet['crypto_wallet'] == 0 && $user->staking_history->count() == 0) 
<div class="modal fade bs-example-modal-center custom-model" tabindex="-1" role="dialog" aria-labelledby="points-alert" aria-hidden="true" style="display: none;" id="points_alert">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-warning text-white">
            <div class="modal-header">
                <h5 class="modal-title mt-0"><span class="mdi mdi-alert"></span> {{trans('custom.notice')}}</h5>
            </div>
            <div class="modal-body">
                <div class="font-16">
                    <?php $string = '<a href="'.route('crypto_wallets').'" class="mtext-cred font-16">'.trans('custom.here').'</a>'; ?>
                    {!! str_replace('#here', $string, trans('custom.points_warning')) !!}
                    <!-- <a href="{{route('crypto_wallets')}}" class="mtext-cred font-16">{{trans('custom.click_here_add_points')}}</a> -->
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endif
@if($user->userwallet['crypto_wallet'] > 0 && $user->staking_history->count() == 0 ) 
{{-- @if($user->userwallet['crypto_wallet'] > 0 || Auth::user()->package_id < 0) --}}
<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="points-alert" aria-hidden="true" style="display: none;" id="points_alert">
    <div class="modal-dialog buyp modal-dialog-centered">
        <div class="modal-content bg-warning text-white">
            <div class="modal-header">
                <h5 class="modal-title mt-0"><span class="mdi mdi-alert"></span> {{trans('custom.notice')}}!</h5>
            </div>
            <div class="modal-body">
                <div class="font-16">
                    {{trans('custom.buy_package_message')}}
                    <a href="{{route('stacks')}}" class="mtext-cred">{{trans('custom.click_here_add_package')}}</a>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@endif
<!-- content-wrapper ends -->
@if ($planExpired)
@foreach ($expired_stacking_pools as $stacking_pool)
<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="points-alert"
aria-hidden="true" style="display: none;" id="planExpired{{ $stacking_pool->id }}">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content cus-blue-bg text-white">
        <div class="modal-header">
            <h5 class="modal-title mt-0"><span class="mdi mdi-alert"></span>
            {{ trans('custom.staking_popup_title') }}</h5>
        </div>
        <div class="modal-body">
            <div class="font-16">
                <?php $text = str_replace('#link', route('stakepool', $stacking_pool->stacking_pool_package_id), str_replace(':Stock', $stacking_pool->name_en, str_replace(':Date', $stacking_pool->end_date, str_replace(':Month', $stacking_pool->staking_period, trans('custom.plan_expired'))))); ?>
                {!! $text !!}
            </div>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
@endforeach
@endif
@endsection
@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
    $('#points_alert').modal('show');

    Highcharts.setOptions({
        colors: ['#d900ff', '#4c27bb', '#57B657']
    });
    var commissionData = {!! json_encode($commissionData) !!};
    Highcharts.chart('hightlinechart', {
        exporting: false,
        title: {
            text: '{{ __('custom.commissions') }}'
        },
        yAxis: {
            title: {
                text: ''
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: ''
            },
            categories: {!! json_encode(array_values($months)) !!}
        },

        legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
            }
        },

        series: [{
            name: "{{ __('custom.apr_monthly') }}",
            data: {!! json_encode(isset($graph['roi_commission']) ? array_values($graph['roi_commission']) : []) !!}
        }, {
            name: "{{ __('custom.referral_commission') }}",
            data: {!! json_encode(isset($graph['referral_commission']) ? array_values($graph['referral_commission']) : []) !!}
        }, {
            name: "{{ __('custom.balancing_commission') }}",
            data: {!! json_encode(isset($graph['pairing_commission']) ? array_values($graph['pairing_commission']) : []) !!}
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
    @if ($user->userwallet->roi != 0 || $user->userwallet->referral_commission != 0 || $user->userwallet->pairing_commission != 0)
    var monthData = [];

    @if (count($commissionData) && isset($commissionData[\Carbon\Carbon::now()->format('m')]))
    monthData = {!! json_encode($commissionData[\Carbon\Carbon::now()->format('m')]) !!};
    @endif
    console.log(monthData);
    var performance = Highcharts.chart('commissionpiechart', {
        exporting:false,
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: "",
            align: 'center',
            verticalAlign: 'middle',
            y: 60
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: false,
                    distance: -50,
                    style: {
                        fontWeight: 'bold',
                        color: 'white'
                    }
                },
                startAngle: -90,
                endAngle: 360,
                center: ['50%', '50%'],
                size: '70%'
            }
        },
        series: [{
            type: 'pie',
            name: "",
            innerSize: '80%',
            data: [
            monthData['apr_monthly'],
            monthData['balancing_commission'],
            monthData['referral_commission'],

            ]
        }]
    });
    @endif
    $(document).on('change', '.grphfilter', function() {
        var month = $(this).val();
        var data = commissionData;
        console.log(month);

        var graphData = data[month];
        var final = [graphData['apr_monthly'],
        graphData['balancing_commission'],
        graphData['referral_commission']
        ];
        $('#apr_monthly').text('$' + graphData['apr_monthly'][1]);
        $('#referral_commission').text('$' + graphData['referral_commission'][1]);
        $('#balancing_commission').text('$' + graphData['balancing_commission'][1]);

        performance.series[0].setData(final);

    })
</script>
@endsection