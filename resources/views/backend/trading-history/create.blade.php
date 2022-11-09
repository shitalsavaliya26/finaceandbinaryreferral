@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12">[{{ $product->name }}] Product Add Trading History</div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content ibox-border-rad cus-heght-full">
                    {!! Form::open(['route' => 'trading-history.store','autocomplete'=>'false','id'=>'product_trading_history_create','method'=>'post', 'files'=>true,]) !!}
                        @include('backend.trading-history.form')
                    {!! Form::close() !!}       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('backend/js/custom/member.js')}}"></script>
@endsection