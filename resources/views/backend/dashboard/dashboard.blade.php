@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{asset('backend/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Dashboard</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
   
    
</div>
@endsection
@section('scripts')
<script src="{{asset('backend/js/plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('backend/js/plugins/chartJs/Chart.min.js')}}"></script>
<script src="{{asset('backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
@endsection
    
