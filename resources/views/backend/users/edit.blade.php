@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-12 p-0">Manage User [{{$user->username}}]</div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                    {!! Form::model($user,['route' => ['user.update',$user->id],'autocomplete'=>'false','id'=>'customer_register_edit','class'=>'fix-input','files'=>true]) !!}
                        @method('patch')
                        @include('backend.users.edit_form')
                    {!! Form::close() !!}    
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