@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-3 p-0">Rank Setting</div>
            {{-- @role('admin') --}}
            <div class="pull-right">
                <a class="btn btn-success btn-sm" href="{{route('rank_setting.create')}}"><i class="fa fa-add-user"></i> Create New Rank</a>
            </div>
            {{-- @endrole --}}
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content bg-dark-blue">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Rank name</th>                            
                                    <!-- <th>Detail</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($ranks) > 0)
                                @foreach($ranks as  $key=>$row)
                                <tr>
                                    @php
                                        $index = $key+1;
                                    @endphp
                                    <td>{{$index}}</td>
                                    <td >{{$row->name}}</td>
                                <!--  <td>
                                        @if($row->status=='active')
                                            <label class="label label-primary">Active</label>   
                                        @else
                                            <label class="label label-danger">In-active</label>   
                                        @endif
                                    </td> -->
                                    <td>
                                        {{-- @role('admin') --}}
                                        {!! Form::open(['route' => ['rank_setting.update',$row->id],'onsubmit'=>"return confirmDelete(this,'Are you sure to want delete ?')"]) !!}
                                        <a class="btn btn-primary btn-xs" href="{{route('rank_setting.edit',[$row->id])}}"><i class="fa fa-edit"></i></a>
                                        @method('delete')
                                        <button class="btn btn-danger  btn-xs" type="submit" ><i class="fa fa-trash"></i></button>
                                        {!! Form::close() !!}
                                        {{-- @else --}}
                                        {{-- N/A --}}
                                        {{-- @endrole --}}
                                    </td>
                                </tr>      
                                @endforeach                            
                                @else
                                <tr>
                                    <td colspan="8">Oops! No Record Found.</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="8" align="right">{!! $ranks->render('vendor.default_paginate') !!}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection