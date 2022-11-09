@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/plugins/dropzone/dropzone.css')}}">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12">[{{ $package->name }}] Package Create New Coin</div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content ibox-border-rad cus-heght-full">
                    
                    {!! Form::open(['route' => 'stacking-pools-coin.store','autocomplete'=>'false','files'=>true,'id'=>'productcoin_create','method'=>'post', 'files'=>true,]) !!}
                        @include('backend.stacking-pools-coin.form')
                    {!! Form::close() !!}       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('backend/js/custom/member.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/plugins/dropzone/dropzone.js')}}"></script>
@endsection