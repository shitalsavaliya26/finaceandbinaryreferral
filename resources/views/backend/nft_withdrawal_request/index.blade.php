@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{asset('backend/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Withdrawal Requests 
            {{-- @role('admin') --}}
            <a class="pull-right btn btn-success btn-sm" onclick="exportBankRequests(this)"><i class="fa fa-cloud-download"></i> Export</a>
            {{-- @endrole --}}
        </h2>
        <div class="col-xs-12 col-md-12 text-right">
            {!! Form::open(['route' => 'nft_withdrawal_request.index','class'=>'form-inline','method'=>'get','id'=>'filter_request']) !!}
            <div class="row m-t-md">
                <div class="form-group">                                
                    {!! Form::select('country',$countries,old('type',@$data['country']),['class'=>'form-control input-sm','placeholder'=>'Select Country']) !!}
                </div>   
                {{-- <div class="form-group">                                
                    {!! Form::select('group[]',$groups,old('group[]',@$data['groups']),['class'=>'form-control input-sm chosen-select','multiple']) !!}
                </div>   --}}
                <div class="form-group">
                    <label class="font-normal"></label>
                    <div class="input-daterange input-group" id="datepicker">
                        {!! Form::text('start',old('start',isset($data['start'])?$data['start']:""),['class'=>'input-sm form-control','placeholder'=>'Start Date','autocomplete'=>'off','readonly'=>'true']) !!}
                        <span class="input-group-addon">to</span>
                        {!! Form::text('end',old('end',isset($data['end'])?$data['end']:""),['class'=>'input-sm form-control','placeholder'=>'End Date','autocomplete'=>'off','readonly'=>'true']) !!}
                    </div>
                </div>  
                <!-- <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('request_date',old('keyword',isset($data['request_date'])?$data['request_date']:''),['class'=>'form-control input-sm','placeholder'=>'Select Date','autocomplete'=>'off','readonly'=>'true']) !!}
                </div>  -->    
                <div class="form-group">                                
                    {!! Form::text('search',old('search',@$data['search']),['class'=>'form-control input-sm','placeholder'=>'Search by username']) !!}
                </div>  
                <div class="form-group">                                
                    {!! Form::select('type',['1'=>'Bank','2'=>'USDT'],old('type',@$data['type']),['class'=>'form-control input-sm','placeholder'=>'All Type']) !!}
                </div>
                <div class="form-group">                                
                    {!! Form::select('status',['Pending'=>'Pending','Approved'=>'Approved','Rejected'=>'Rejected'],old('status',@$data['status']),['class'=>'form-control input-sm','placeholder'=>'All Status']) !!}
                </div>           
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-filter"></i> Search</button>
                <a class="btn btn-danger  btn-sm" href="{{route('nft_withdrawal_request.index')}}">Clear</a>
            </div>
            <label id="start-error" class="error" for="start"></label>
            <label id="end-error" class="error" for="end"></label>
            {!! Form::close() !!}      
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">

                <div class="ibox-content  bg-dark-blue">
                    {{-- @role('admin') --}}
                    <div class="row form-inline ml-0 mr-0">
                        <div class="col-sm-4 text-left">
                            <label class="text-white">Bulk Action: </label>
                            {!! Form::select('bulk_action',['1'=>'Approved','2'=>'Rejected'],old('bulk_action',@$data['bulk_action']),['class'=>'form-control','placeholder'=>'Select Action']) !!}
                            <a class="btn btn-warning btn-sm bulk-apply" href="#"><i class="fa fa-check"></i> Apply</a>
                        </div>
                    </div>
                    {{-- @endrole --}}
                    <div class="clearfix"></div>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                {{-- <th>@role('admin')<label>{!! Form::checkbox('checkall','123',false) !!} @endrole #ID</label></th> --}}
                                <th><label>{!! Form::checkbox('checkall','123',false) !!}  #ID</label></th>
                                <th colspan="">User detail</th>
                                <th>NFT</th>
                                <th>Title</th>
                                <th>NFT Category</th>
                                <th>NFT Address</th>
                                <th>Submitted date</th>
                                <th>Updated date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @php  $i = 1;  @endphp
                        <tbody>
                            @if(count($withdrawal_requests) > 0)
                            @foreach($withdrawal_requests as $row)
                            <tr>
                                <td>
                                    <label>@if($row->status == '0'){!! Form::checkbox('request_ids[]',$row->id,false ) !!}@endif {{$i++}}</label>
                                </td>


                                <td colspan="" width="20%">
                                    {{$row->user_detail->username}}                                 
                                </td>

                
                                <td style="max-width: 100px;">
                                    <img src="{{ asset($row->nftproduct->image) }}"
                                    class="img-fluid rounded-0 w-auto h-auto" alt="" id="salehistoryimage" style="width: 100%;">
                                </td>  
                                
                                
                                <td>{{ $row->nftproduct->name }}</td>
                                <td>{{ $row->nftproduct->nftcategory->name }}</td>
                                <td>{{ $row->payment_address }}</td>

                                <td>{{$row->created_at ? $row->created_at : ""}}</td>

                                <td>{{$row->action_date ? $row->action_date : ""}}</td>
                                <td>
                                    @if($row->status=='1')
                                    <label class="label label-primary">Approved</label>
                                    @elseif($row->status=='2')
                                    <label class="label label-danger">Rejected</label>
                                    @else
                                    <label class="label label-warning">Pending</label>
                                    @endif
                                </td>
                                <td width="15%">
                                    {{-- @role('admin') --}}
                                    {!! Form::open(['route' => ['nft_withdrawal_request.update',$row->id],'onsubmit'=>"return false;"]) !!}
                                    @if($row->status == '0')
                                    {!! Form::hidden('username',$row->user_detail->username) !!}
                                    {!! Form::hidden('withdraw_request_id',$row->id) !!}
                                    <a class="btn btn-success btn-xs btn-status" data-toggle="tooltip" data-value="1" title="Approved" href="#"><i class="fa fa-check" ></i></a>
                                    <a class="btn btn-danger btn-xs btn-status"  data-value="2" data-toggle="tooltip" title="Rejected" href="#"><i class="fa fa-times"></i></a>
                                    @endif
                                    @if (!empty($row->payment_proof))
                                    <button class="btn btn-info  btn-xs"  data-type="{{$row->type}}"  data-id="{{$row->id}}"   data-toggle="tooltip" onclick="getBankProof($(this))" title="View Bank Proof" type="submit" ><i class="fa fa-id-card"></i></button>
                                    @endif
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
                                <td colspan="10" align="right">{!! $withdrawal_requests->render('vendor.default_paginate') !!}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hidden">
    {!! Form::open(['route' => ['nft_withdrawal_request.update','bulk-update'],'id'=>"update_withdrawal_requests"]) !!}
    @method('patch')
    {!! Form::hidden('withdraw_request_id[]','') !!}
    {!! Form::hidden('status','0') !!}
    <button class="btn btn-info  btn-xs" type="submit" ><i class="fa fa-id-card"></i></button>
    {!! Form::close() !!}
</div>
<div id="open_remark_modal" class="modal fade open-remark-model" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open(['route'=>['nft_withdrawal_request.update',''],'method'=>'post','class'=>'form-vertical','id'=>'open_remark_model','autocomplete'=>'false','files'=>true]) !!}
            @method('patch')
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="status text-capitalize"></span> withdraw request of <span class="username"></span></h4>
            </div>
            <div class="modal-body">
                {!! Form::hidden('request_id','') !!}
                {!! Form::hidden('status','') !!}
                <div class="form-group">
                    <label>Transaction Id:</label> 
                    {!! Form::text('transaction_id',old('transaction_id'),['class'=>'form-control','placeholder'=>'Transaction Id']) !!}
                    <span class="help-block text-danger">{{ $errors->first('transaction_id') }}</span>
                </div>
                <div class="form-group">
                    <label>Remark:</label> 
                    {!! Form::textarea('remark',old('remark'),['class'=>'form-control','placeholder'=>'Enter Note','rows'=>4,'resize'=>'false']) !!}
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


<div id="remark_decline" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body remark-decline p-0">


            </div>
            <div class="modal-footer">
                <a  class="btn btn-danger" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">  
    var update_url = "{{route('nft_withdrawal_request.update',[''])}}"; 
    var report_export = "{{route('nft_withdrawal_request.export')}}"; 
    var detail_url = "{{route('nft_withdrawal_request.bank_proofs')}}"; 
</script>
<script src="{{asset('backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
    //  $('.chosen-select').val({!! json_encode(@$data['group']) !!}).chosen({width: "100%"});
</script> 
<script type="text/javascript" src="{{asset('backend/js/custom/withdrawal_requests.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/custom/reports.js')}}"></script>
@endsection
