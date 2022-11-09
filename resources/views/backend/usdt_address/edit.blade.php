@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-4 p-0">Manage USDT Address [{{$usdt_address->name}}]</div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                    <div class="ibox-content ibox-border-rad cus-heght-full">
                    {!! Form::model($usdt_address,['route' => ['usdt_address.update',$usdt_address->id],'autocomplete'=>'false','id'=>'usdt_address','files'=>true]) !!}
                        @method('patch')
                        @include('backend.usdt_address.form')
                    {!! Form::close() !!}    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
     var verify_sponsor = "{{route('sponsorUsernameExits')}}";
</script>
<script type="text/javascript" src="{{asset('backend/js/custom/member.js')}}"></script>
@endsection