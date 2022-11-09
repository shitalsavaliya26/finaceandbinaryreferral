@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Wallet History</h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight p-b-none">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content ibox-border-rad ">
                    <h4 class="m-b-none">
                        {{$user->username}}
                        <div class="pull-right"> 
                            <a class="fs-14 ctext-red" href="{{route('user.edit',$user->id)}}"> Edit Profile</a>
                        </div>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight m-t-n-lg">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content bg-dark-blue cus-tab-nav">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="@if($tab_name == 'crypto_wallets') active @endif">
                            <a  href="{{route('crypto-wallet-history.show',[$user->id])}}" aria-expanded="false">Crypto <br>Wallet</a>
                        </li>
                        <li class="@if($tab_name == 'nft_wallets') active @endif">
                            <a  href="{{route('nft-wallet-history.show',[$user->id])}}" aria-expanded="true">NFT <br>Wallet</a>
                        </li>
                        <li class="@if($tab_name == 'yield_wallets') active @endif">
                            <a href="{{route('yield-wallet-history.show',[$user->id])}}" aria-expanded="true">Yield <br>Wallet</a>
                        </li>
                        <li class="@if($tab_name == 'commission_wallets') active @endif">
                            <a href="{{route('commission-wallet-history.show',[$user->id])}}" aria-expanded="true">Commission<br>Wallet</a>
                        </li>
                        {{--<li class="@if($tab_name == 'overriding') active @endif">
                            <a href="{{route('admin_user_overridding_wallet',[$user->id])}}" aria-expanded="true">Overriding <br>Wallet</a>
                        </li>--}}
                        {{-- <li class="@if($tab_name == 'leader_bonus') active @endif">
                            <a  href="{{route('admin_user_leader_bonus',[$user->id])}}" aria-expanded="true">Leader bonus <br> wallet</a>
                        </li> --}}
                                                {{-- <li class="@if($tab_name == 'profit_sharing') active @endif">
                            <a href="{{route('admin_user_profit_sharing',[$user->id])}}" aria-expanded="true">Profit sharing <br>Wallet</a> --}}
                        {{-- </li> --}}
                        {{-- <li class="@if($tab_name == 'mt_wallet') active @endif">
                            <a  href="{{route('admin_user_mt4_wallet',[$user->id])}}" aria-expanded="true">MT5 <br>Wallet</a>
                        </li> --}}
                    </ul>
                    {{-- @php
                        dump($tab_name);
                    @endphp --}}
                    <div class="tab-content">
                        @include('backend.users.partials.'.$tab_name)                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('backend/js/custom/wallet.js')}}"></script>
@endsection