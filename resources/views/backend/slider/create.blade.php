@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-4 p-0">Create New slider</div>                           
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                 {!! Form::open(['route' => 'slider.store','autocomplete'=>'false','files'=>true,'id'=>'slider-form','method'=>'post']) !!}
                 @include('backend.slider.form')
                 {!! Form::close() !!}       
             </div>
         </div>
     </div>
 </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('backend/js/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/custom/member.js')}}"></script>
@endsection