@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12">Manage Packages [{{$package->name}}]</div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                    <div class="ibox-content ibox-border-rad cus-heght-full">
                    {!! Form::model($package,['route' => ['packages.update',$package->id],'autocomplete'=>'false','id'=>'package_edit','files'=>true]) !!}
                        @method('patch')
                        @include('backend.package.form')
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