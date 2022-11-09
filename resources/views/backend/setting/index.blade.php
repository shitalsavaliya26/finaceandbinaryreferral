@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{asset('backend/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-3 p-0">General Setting</div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
                @include('backend.setting.partials.form')
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/custom/setting.js')}}"></script>

{{-- @role('admin') --}}
{{-- @else --}}
{{-- <script type="text/javascript">
    $(document).ready(function(){
        $('input').attr('readonly',true);
    })
</script> --}}
{{-- @endrole --}}
@endsection