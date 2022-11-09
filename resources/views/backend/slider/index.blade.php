@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{asset('backend/css/plugins/blueimp/css/blueimp-gallery.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-4 p-0">Slider</div>
            {{-- @role('admin') --}}
            <div class="col-xs-12 col-md-8 text-right">
                <a class="btn btn-success btn-sm btn-xs-block" href="{{route('slider.create')}}">Add slider</a>
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
                    <div class="table-responsive blueimp-gallery-div">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th width="20%">Desktop Image</th>
                                    <th width="20%">Mobile Image</th>
                <!--                 <th>Start date</th>
                                <th>End date</th>
                            -->                                <th>Action</th>
                        </tr>
                    </thead>
                    @php  $i =  1;  @endphp
                    <tbody>
                        @if(isset($sliders) && count($sliders) > 0)
                        @foreach($sliders as $row)
                        <tr class="row-user-{{$row->id}}">

                            <td>{{@$row->title}}</td>                             
                            <td> <a class="blueimp-link" href="{{asset($row->image)}}" data-gallery="" target="_blank" title='{{$row->title}}'>
                                            <img onerror="this.src='{{asset('backend/media/no_found.png')}}'" src="{{asset($row->image)}}" width="auto" height="50px">
                                        </a></td>  
                                  <td width="10%">      

                                    <a class="blueimp-link" href="{{asset($row->mobile_image)}}" data-gallery="" target="_blank" title='{{$row->title}}'>
                                            <img onerror="this.src='{{asset('backend/media/no_found.png')}}'" src="{{asset($row->mobile_image)}}" width="auto" height="50px">
                                        </a>
<!--                                     <img src="{{asset('uploads/slider/'.$row->image)}}" alt="Banner Image" class="img-fluid img-responsive investment-graph-image"></td>
 -->                                <!-- <td>{{@$row->startdate}}</td>                             
                                    <td>{{@$row->enddate}}</td> -->  
                                    <td width="20%">
                                        {{-- @role('admin') --}}
                                        {!! Form::open(['route' => ['slider.destroy',$row->id],'onsubmit'=>"return confirmDelete(this,'Are you sure to want delete ?')",'id'=>'formNewsDel'.$row->id]) !!}
                                        <a class=""  href="{{route('slider.edit',[$row->id])}}">Edit</a> | 
                                        @method('delete')
                                        <a class=""  type="submit" onclick="$('#formNewsDel{{$row->id}}').submit()" >Delete</>
                                            {!! Form::close() !!}
                                            {{-- @else
                                            N/A
                                            @endif --}}
                                        </td>
                                    </tr>           
                                    @endforeach                            
                                    @else
                                    <tr>
                                        <td colspan="10">Oops! No Record Found.</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="5" align="right">{!! $sliders->render('vendor.default_paginate') !!}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <div class="description"></div>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    @endsection
    @section('scripts')
    <script type="text/javascript" src="{{asset('backend/js/custom/member.js')}}"></script>
    <script src="{{asset('backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('backend/js/plugins/blueimp/jquery.blueimp-gallery.min.js')}}"></script>

    <script type="text/javascript">
       var options = {
        container: document.getElementByClassName('blueimp-gallery-div'),
        slidesContainer: 'div',
        titleElement: 'h3',
        indicatorContainer: 'ol'
    }
    blueimp.Gallery($('a.blueimp-link'),options );
</script>
@endsection