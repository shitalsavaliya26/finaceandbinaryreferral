@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{asset('backend/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
<link href="{{asset('backend/css/plugins/blueimp/css/blueimp-gallery.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- {{$errors}} -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            {!! Form::open(['route' => 'crypto_wallets_credit_request.index','class'=>'form-inline','method'=>'get','id'=>'filter_data_ajax']) !!}
            <div class="col-xs-12 col-md-6 p-0">Crypto Wallets Credits Requests</div>
            <div class="col-xs-12 col-md-6 text-right">
                {{-- @role('admin') --}}
                <div class="pull-right">
                    <a class="btn btn-primary" onclick="exportBankRequests(this)" ><i class="fa fa-cloud-download"></i> Export</a>
                </div>   
                {{-- @endrole --}}
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 text-right m-t-md">
                    <div class="row fromgroup-full">
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('request_date',old('keyword',isset($data['request_date'])?$data['request_date']:''),['class'=>'form-control','placeholder'=>'Select Date','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <div class="form-group">                                
                                {!! Form::text('username',old('username',isset($data['username'])?$data['username']:''),['class'=>'form-control','placeholder'=>'Username','autocomplete'=>'off']) !!}
                            </div>  
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <div class="form-group"> 
                                {!! Form::select('status',['Pending'=>'Pending','Approved'=>'Approved','Rejected'=>'Rejected'],old('status',isset($data['status'])?$data['status']:''),['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2"> 
                            <div class="form-group"> 
                                {!! Form::text('remark',old('remark',isset($data['remark'])?$data['remark']:''),['class'=>'form-control','placeholder'=>'Remark','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2 m-t-xs text-right">                
                            <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Search</button>
                            <a class="btn btn-danger" href="{{route('crypto_wallets_credit_request.index')}}">Clear</a>
                        </div>
                    </div>            
                </div>
            </div>
        </h2>
        {!! Form::close() !!}
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <h4>Total Sales:<span class="border-bottom page-heading">$ {{$data['total_sales']}}</span> &nbsp;&nbsp;&nbsp; Total Uploads :<span class="border-bottom page-heading">{{$data['total_uploads']}}</span></h4>
                <div class="ibox-content  bg-dark-blue">
                    <div class="table-responsive blueimp-gallery-div">
                    <table class="table table-stripped">
                        <thead>                           
                            <tr>
                                <th width="10%">#Id</th>
                                <th width="10%">Type</th>
                                <th width="10%">Username</th>
                                <th width="10%">Credits</th>
                                <th width="10%">Transaction Slip</th>
                                <th width="15%">Remark</th>
                                <th width="10%">Date</th>
                                <th width="25%">Status</th>
                            </tr>
                        </thead>
                            @if(isset($crypto_credit) && count($crypto_credit)>0)
                                @php  $j= 1;  @endphp
                                @foreach($crypto_credit as $funds)
                                <tbody>
                                <tr>
                                    <td>{{str_replace("-", "", $funds->created_at->format('d-m-y'))}}-{{sprintf("%04d", $funds->unique_no)}}</td>

                                    <td><label class="label label-info">{{($funds->type==7)? (($funds->user_detail && $funds->user_detail->country_id == '45') ? 'RMB' : 'IDR'):'USDT'}}</label></td>
                                 
                                    <td>
                                        {{$funds->user_detail!=null?$funds->user_detail->username:""}}
                                    </td>

                                    <td>{{$funds->amount}}</td>

                                    <td>
                                        @if($funds->trans_slip != "")
                                        <a class="blueimp-link" href="{{asset('uploads/upload_bank_proof/'.$funds->trans_slip)}}" data-gallery="" target="_blank" title='{{str_replace("-", "", $funds->created_at->format("d-m-y"))}}-{{sprintf("%04d", $funds->unique_no)}}'>
                                             <img onerror="this.src='{{asset('backend/media/no_found.png')}}'" src="{{asset('uploads/upload_bank_proof/'.$funds->trans_slip)}}" width="auto" height="50px">
                                        </a>
                                        @endif
                                    </td>

                                    <td  class="break-word txt-remark-{{$funds->id}}">{{$funds->remark}}</td>
                                    
                                    <td>{{$funds->created_at->format('Y-m-d')}}</td>
                                    <td>@if($funds->type == 5)
                                        <label class="label label-success">Added</label>
                                        @else
                                        @if($funds->status == 0)
                                        {{-- @role('admin') --}}
                                        <!-- <div class="btn-group"> -->
                                            <a class="btn btn-sm btn-success maestro" data-id="{{$funds->id}}" data-type="approve" data-value="1" href="#">Approve</a>

                                            <a class="btn btn-sm btn-danger"  href="#" data-type="remark"  data-amount="{{$funds->amount}}" data-id="{{$funds->id}}" data-username="{{$funds->user_detail!=null?$funds->user_detail->username:''}}" onclick="updateRemark(this)">Reject</a> 

                                            {{-- <a class="btn btn-sm btn-primary" data-amount="{{$funds->amount}}" data-id="{{$funds->id}}" data-username="{{$funds->user_detail!=null?$funds->user_detail->username:''}}" onclick="opFundWallet(this)" >Edit</a>
                                            <a class="btn btn-sm btn-primary " data-type="remark"  data-amount="{{$funds->amount}}" data-id="{{$funds->id}}" data-username="{{$funds->user_detail!=null?$funds->user_detail->username:''}}" onclick="updateRemark(this)" >Remark</a> --}}
                                            {{-- @else
                                        N/A
                                        @endrole --}}
                                        <!-- </div>   -->
                                        @elseif($funds->status == 1)
                                            <label class="label label-primary">Approved</label>
                                        @elseif($funds->status == 2)
                                            <label class="label label-danger">Rejected</label>

                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                </tbody>                                        
                                @endforeach
                                <tr align="right">
                                    <td colspan="9"  align="right">{!! $crypto_credit->render('vendor.default_paginate') !!}</td>
                                </tr>

                            @else
                            <tbody >
                                <tr align="left">
                                    <td colspan="9">Oops! No Record Found.</td>
                                </tr>
                            </tbody >
                            @endif
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
<div id="edit_credit_request" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open(['route'=>['crypto_wallets_credit_request.update',''],'method'=>'post','class'=>'form-vertical','id'=>'credit_request_form','autocomplete'=>'false','files'=>true]) !!}
            @method('patch')
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit request of <span class="username"></span></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="request_id" value="" />
                    <label>Amount:</label> 
                     {!! Form::number('amount',old('amount'),['min'=>'1','class'=>'form-control','placeholder'=>'Enter Amount']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                </div>
                <div class="form-group">
                    <label>Payment Proof:</label> 
                     {!! Form::file('trans_slip',['class'=>'form-control','placeholder'=>'Enter Note','rows'=>4,'resize'=>'false']) !!}
                    <span class="help-block text-danger">{{ $errors->first('trans_slip') }}</span>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Submit</button>
                <a  class="btn btn-danger" data-dismiss="modal">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div id="update_remark" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open(['route'=>['crypto_wallets_credit_request.update',''],'method'=>'post','class'=>'form-vertical','id'=>'credit_remark_form','autocomplete'=>'false','files'=>true]) !!}
            @method('patch')
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reject bank credit request of <span class="username"></span></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="request_id" value="" />
                    <input type="hidden" name="status" value="2" />
                    <label>Remark:</label> 
                     {!! Form::textarea('remark',old('remark'),['rows'=>'5','class'=>'form-control','placeholder'=>'Enter Remark','style'=>'resize:none;']) !!}
                    <span class="help-block text-danger">{{ $errors->first('remark') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Submit</button>
                <a  class="btn btn-danger" data-dismiss="modal">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
   var route_url = "{{route('crypto_wallets_credit_request.update',[''])}}" 
   var url_remark = "{{route('crypto_wallets_credit_request.update',[''])}}" ;
   var export_url = "{{route('crypto_wallets_credit_request.export')}}" ;
   $('.chosen-select').chosen({width: "100%"});
   $('#update_remark').on('hidden.bs.modal', function() {
            $('#update_remark form')[0].reset();
            $("label.error").hide();
    });

</script>
<script src="{{asset('backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('backend/js/plugins/blueimp/jquery.blueimp-gallery.min.js')}}"></script>
<script src="{{asset('backend/js/custom/wallet.js')}}"></script>
<script type="text/javascript">
    var options = {
        container: document.getElementsByClassName('blueimp-gallery-div'),
        slidesContainer: 'div',
        titleElement: 'h3',
        indicatorContainer: 'ol'
    };
    blueimp.Gallery($('a.blueimp-link'),options )
</script>
@endsection