@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-12 p-0">Edit News [<span class="h4">{{@$news->title}}</span>]</div>                           
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    {!! Form::model($news,['route' => ['news.update',$news->id],'autocomplete'=>'false','files'=>true,'id'=>'news-form-edit']) !!}
                        @method('patch')
                        @include('backend.news.form')
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