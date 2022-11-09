@extends('layouts.backend.main')
@section('title', 'Edit slider')
@section('css')
<link href="{{asset('backend/css/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-12 p-0">Edit slider [<span class="h4">{{@$slider->title}}</span>]</div>                           
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    {!! Form::model($slider,['route' => ['slider.update',$slider->id],'autocomplete'=>'false','id'=>'slider-form-edit','files'=>true,'method'=>'POST']) !!}
                    @method('PUT')
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