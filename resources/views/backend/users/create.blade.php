@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-3 p-0">New User</div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                    {!! Form::open(['route' => 'user.store','autocomplete'=>'false','files'=>true,'id'=>'customer_register','class'=>'fix-input','method'=>'post']) !!}
                        @include('backend.users.form')
                    {!! Form::close() !!}       
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
     var verify_sponsor = "{{route('sponsorUsernameExits')}}";
     var placementUsernameExits = "{{route('placementUsernameExits')}}";
</script>
<script type="text/javascript" src="{{asset('backend/js/custom/member.js')}}"></script>
@endsection