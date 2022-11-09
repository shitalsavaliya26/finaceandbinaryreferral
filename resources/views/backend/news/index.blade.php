@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-4 p-0">News</div>
            {{-- @role('admin') --}}
            <div class="col-xs-12 col-md-8 text-right">
                <a class="btn btn-success btn-sm btn-xs-block" href="{{route('news.create')}}">Create News</a>
            </div>
            {{-- @endrole --}}
        </h2>
        
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins bg-dark-blue">
                <div class="ibox-content ">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Language</th>
                                    <th>Title</th>
                                    <!-- <th>Detail</th>
                                    <th>Url</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @php  $i =  1;  @endphp
                            <tbody>
                                @if(count($news) > 0)
                                @foreach($news as $row)
                                <tr class="row-user-{{$row->id}}">
                                    
                                    <td>
                                    @if($row->lang=='en')
                                        English

                                    @elseif($row->lang=='cn')
                                        Chinese
                                    @else
                                        Korean
                                    @endif
                                    </td>                             
                                    <td>{{@$row->title}}</td>                             
                                    <!-- <td>{{@$row->details}}</td>                             
                                    <td width="25%">{{@$row->url}}</td>-->                        
                                    <td>
                                        @if($row->status=='Active')
                                            <label class="label label-primary">Active</label>   
                                        @else
                                            <label class="label label-danger">In-active</label>   

                                        @endif
                                    </td>
                                    <td width="20%">
                                        {{-- @role('admin') --}}
                                        {!! Form::open(['route' => ['news.destroy',$row->id],'onsubmit'=>"return confirmDelete(this,'Are you sure to want delete ?')",'id'=>'formNewsDel'.$row->id]) !!}
                                        <a class=""  href="{{route('news.edit',[$row->id])}}">Edit</a> | 
                                        @method('delete')
                                        <a class=""  type="submit" onclick="$('#formNewsDel{{$row->id}}').submit()" >Delete</>
                                        {!! Form::close() !!}
                                        {{-- @else --}}
                                        {{-- N/A --}}
                                        {{-- @endrole --}}
                                    </td>
                                </tr>           
                                @endforeach                            
                                @else
                                <tr>
                                    <td colspan="10">Oops! No Record Found.</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="10" align="right">{!! $news->render('vendor.default_paginate') !!}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 hidden">
            <div class="ibox float-e-margins bg-dark-blue">
                <div class="ibox-title">
                    <h4>Announcement</h4>
                </div>
                <div class="ibox-content ">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @php  $i =  1;  @endphp
                            <tbody>
                                @if(isset($announcement) && count($announcement) > 0)
                                @foreach($news as $row)
                                <tr class="row-user-{{$row->id}}">
                                    
                                    <td>{{$row->lang=='en'?'English':'Chinese'}}</td>                             
                                    <td>{{@$row->title}}</td>                             
                                    <!-- <td>{{@$row->details}}</td>                             
                                    <td width="25%">{{@$row->url}}</td>      -->                        
                                    <td>
                                    </td>
                                    <td width="20%">
                                        {!! Form::open(['route' => ['news.destroy',$row->id],'onsubmit'=>"return confirmDelete(this,'Are you sure to want delete ?')",'id'=>'formNewsDel'.$row->id]) !!}
                                        <a class=""  href="{{route('news.edit',[$row->id])}}">Edit</a> | 
                                        @method('delete')
                                        <a class=""  type="submit" onclick="$('#formNewsDel{{$row->id}}').submit()" >Delete</>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>           
                                @endforeach                            
                                @else
                                <tr class="text-center">
                                    <td colspan="5">No recored exists</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="5" align="right">{!! $news->render('vendor.default_paginate') !!}</td>
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
<script type="text/javascript" src="{{asset('backend/js/custom/member.js')}}"></script>
@endsection