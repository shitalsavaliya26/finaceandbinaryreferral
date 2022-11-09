@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-3 p-0">USDT Address Setting</div>
            {{-- @role('admin') --}}
            <div class="pull-right">
                <a class="btn btn-success btn-sm" href="{{route('usdt_address.create')}}"><i class="fa fa-add-user"></i> Create New</a>
            </div>
            {{-- @endif --}}
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
                                    <th>Image</th>
                                    <th colspan="2">Name</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($addresses) > 0)
                                @foreach($addresses as  $key=>$row)
                                <tr>
                                    @php
                                        $index = $key+1;
                                    @endphp
                                    <td>{{$index}}</td>
                                    <td>
                                        @if($row->image)
                                        <img src="{{$row->image}}" alt="Image" class="img-fluid img-responsive investment-graph-image">
                                        @endif
                                    </td>
                                    <td colspan="2" width="30%">
                                        {{$row->name}}  
                                    </td>
                                    <td>{{@$row->value}}</td> 
                                    <td>
                                    @if($row->status=='1')
                                    <label class="label label-primary">Active</label>
                                    @else
                                    <label class="label label-danger">Inactive</label>
                                    @endif
                                </td> 
                                    <td>
                                        {{-- @role('admin') --}}
                                        {!! Form::open(['route' => ['usdt_address.update',$row->id],'onsubmit'=>"return confirmDelete(this,'Are you sure to want delete this package ?')"]) !!}
                                        <a class="btn btn-primary btn-xs" href="{{route('usdt_address.edit',[$row->id])}}"><i class="fa fa-edit"></i></a>
                                        @method('delete')
                                        <button class="btn btn-danger  btn-xs" type="submit" ><i class="fa fa-trash"></i></button>
                                        {!! Form::close() !!}
                                        {{-- @else --}}
                                        {{-- - --}}
                                        {{-- @endrole --}}
                                    </td>
                                </tr>                                        
                                @endforeach                            
                                @else
                                <tr>
                                    <td colspan="7">Oops! No Record Found.
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="7" align="right">{!! $addresses->render('vendor.default_paginate') !!}</td>
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