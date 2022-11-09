@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{asset('backend/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-4 p-0">Stacking Pool History</div>
            <div class="col-xs-12 col-md-8 text-right">
                {{-- @role('admin') --}}
                    <a class="btn  btn-info" onclick="exportstackingpollhistoryFunction()">Export</a>
                {{-- @endrole --}}
            </div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 text-left m-b-md">
            {!! Form::open(['route' => 'stacking_pool_history.index','class'=>'form-inline','method'=>'get','id'=>'filter_request']) !!}
                <div class="col-sm-12 p-0">           
                    {{-- <div class="input-daterange input-group" id="datepicker">
                        {!! Form::text('start',old('start',isset($data['start'])?$data['start']:""),['class'=>'input-sm form-control','placeholder'=>'Start Date','readonly'=>'true']) !!}
                        <span class="input-group-addon">to</span>
                        {!! Form::text('end',old('end',isset($data['end'])?$data['end']:""),['class'=>'input-sm form-control','placeholder'=>'End Date','readonly'=>'true']) !!}
                    </div>                                                    --}}
                    {{-- <div class="form-group">                                
                        {!! Form::select('type',['1'=>'USDT','2'=>'Malasian Payment','3'=>'Coin Payment','4'=>'Admin Added','5'=>'Admin Reduced'],old('status',@$data['type']),['class'=>'form-control','placeholder'=>'All']) !!}
                    </div>  --}}
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">                                
                            {!! Form::text('username',old('username',isset($data['username'])?$data['username']:''),['class'=>'form-control','placeholder'=>'Username','autocomplete'=>'off']) !!}
                        </div>  
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">                                
                            {!! Form::select('status',['1'=>'Active','2'=>'Closed'],old('status',@$data['status']),['class'=>'form-control','placeholder'=>'All Status']) !!}
                        </div>
                    </div>
                          
                    <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Search</button>
                    <a class="btn btn-danger" href="{{route('stacking_pool_history.index')}}">Clear</a>
                </div>
                 <label id="start-error" class="error" for="start"></label>
                <label id="end-error" class="error" for="end"></label>
            {!! Form::close() !!}   
        </div>
        
        <div class="col-lg-12">
            <div class="ibox ">
                <h4>Total Amount:<span class="border-bottom page-heading">$ {{$total_amount}}</span> </h4>
                <div class="ibox-content bg-dark-blue">
                    <div class="include-html">
                        @include('backend.stacking_pool_history.partials.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript"> 
var report_export = "{{route('stacking_pool_history.export')}}" 
</script>
<script src="{{asset('backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/custom/reports.js')}}"></script>
@endsection