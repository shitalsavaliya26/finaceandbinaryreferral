@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{ asset('backend/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
@endsection
@section('content')
<!-- {{ $errors }} -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>
            {!! Form::open(['route' => 'nft_purchase_request.index', 'class' => 'form-inline', 'method' => 'get', 'id' => 'filter_data_ajax']) !!}
            <div class="col-xs-12 col-md-6 p-0">NFT Sell Request</div>
            <div class="col-xs-12 col-md-6 text-right">
                {{-- @role('admin') --}}
                {{-- <div class="pull-right">
                    <a class="btn btn-primary" onclick="exportnftpRequests(this)"><i class="fa fa-cloud-download"></i>
                    Export</a>
                </div> --}}
                {{-- @endrole --}}
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 text-right m-t-md">
                    <div class="row fromgroup-full">
                        <div class="col-xs-12 col-md-2">
                            <div class="input-group date">
                                <span class="input-group-addon"><i
                                    class="fa fa-calendar"></i></span>{!! Form::text('request_date', old('keyword', isset($data['request_date']) ? $data['request_date'] : ''), ['class' => 'form-control', 'placeholder' => 'Select Date', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <div class="form-group">
                                    {!! Form::text('username', old('username', isset($data['username']) ? $data['username'] : ''), ['class' => 'form-control', 'placeholder' => 'Username', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <div class="form-group">
                                    {!! Form::select('status', ['' => 'All','1' => 'Listing', '2' => 'On Sale', '3' => 'Declined', '4' => 'Counter Offer Rejected','5' => 'Processing','6' => 'Counter Offer Created','7' => 'Sold'], old('status', isset($data['status']) ? $data['status'] : ''), ['class' => 'form-control']) !!}
                                </div>
                            </div> 
                            <div class="col-xs-12 col-md-2 m-t-xs text-right">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Search</button>
                                <a class="btn btn-danger" href="{{ route('nft_purchase_request.index') }}">Clear</a>
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
                    {{-- <h4>Total Sales:<span class="border-bottom page-heading">$ {{ $data['total_sales'] }}</span>
                        &nbsp;&nbsp;&nbsp; Total Uploads :<span
                        class="border-bottom page-heading">{{ $data['total_uploads'] }}</span></h4> --}}
                        <div class="ibox-content  bg-dark-blue">
                            <div class="table-responsive blueimp-gallery-div">
                                <table class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>#Id</th>
                                            <th>Username</th>
                                            <th>Product</th>
                                            <th>Purchased Amount</th>
                                            <th>Sale Amount</th>
                                            <th>Order ID</th>
                                            <th>Purchase Date</th>
                                            {{-- <th>Sell Date</th> --}}
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if (isset($nft_purchase_history) && count($nft_purchase_history) > 0)
                                    @php  $i = 1;  @endphp
                                    @foreach ($nft_purchase_history as $row)
                                    <tbody>
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->user_detail->username }}</td>
                                            <td>{{ $row->nftproduct->name }}</td>
                                            <td>
                                                {{ number_format($row->nftpurchasehistory->amount, 2) }}
                                            </td>
                                            <td>
                                                {{ number_format($row->sale_amount, 2) }}
                                            </td>
                                            <td>
                                                {{ $row->order_id ?? '' }}
                                            </td>
                                            <td>{{ $row->purchase_date ? $row->purchase_date->format('Y-m-d') : $row->created_at->format('Y-m-d') }}
                                            </td>
                                            {{-- <td>{{ $row->sell_date ? $row->sell_date : ' ' }}</td> --}}
                                            <td id="statusproduct">
                                                @if ($row->status == 1)
                                                <label class="label label-primary">Listing</label>
                                                @elseif ($row->status == 2)
                                                <label class="label label-danger">On Sale</label>
                                                @elseif ($row->status == 3)
                                                <label class="label label-danger">Declined</label>
                                                @elseif ($row->status == 4)
                                                <label class="label label-danger">Counter Offer Rejected</label>
                                                @elseif ($row->status == 5)
                                                <label class="label label-warning">Processing</label>
                                                @elseif ($row->status == 6)
                                                <label class="label label-info">Counter Offer Created</label>
                                                @elseif ($row->status == 7)
                                                <label class="label label-success">SOLD</label>
                                                @else
                                                <label class="label label-danger">Counter Offer Reject</label>
                                                @endif
                                            </td>
                                            <td width="25%">
                                                {{-- @if ($row->status == '3')
                                                <label class="label label-info">Processing</label>
                                                @elseif ($row->status=='2') --}}
                                                {{-- <label class="label label-success">On Sale</label> --}}
                                                {{-- @role('admin') --}}
                                                <!-- <div class="btn-group"> -->
                                                    @if ($row->status == 2)
                                                    <a class="btn btn-success nftonsalereq"
                                                    data-id="{{ $row->id }}" data-type="processing"
                                                    data-value="5" href="#">Mark As Proccesing</a>
                                                    @elseif ($row->counter_offer_status == '1')
                                                    <a class="btn btn-warning" href="#" style="margin-left:18px;"
                                                    disabled>Waiting for User Response</a>
                                                    @elseif ($row->counter_offer_status == '2')
                                                    -
                                                    @elseif ($row->counter_offer_status == '3')
                                                    -
                                                    @elseif($row->status == 1)
                                                    <a class="btn btn-success nftreq"
                                                    data-id="{{ $row->id }}" data-type="approve"
                                                    data-value="2" href="#">Approve</a>

                                                    <a class="btn btn-danger nftreq" href="#" data-type="reject"
                                                    data-id="{{ $row->id }}" data-value="3">Reject</a>

                                                    {!! Form::open(['route' => ['nft_purchase_request.update', $row->id], 'onsubmit' => 'return false;','style'=>"display:inline-block"]) !!}
                                                    {!! Form::hidden('username', $row->user_detail->username) !!}
                                                    {!! Form::hidden('nft_purchase_request', $row->id) !!}
                                                    {!! Form::hidden('user_sale_amount', $row->sale_amount) !!}
                                                    <a class="btn btn-primary counterofferbtn" href="#"
                                                    data-toggle="tooltip" data-type="counteroffer"
                                                    >Counter Offer</a>
                                                    {!! Form::close() !!}

                                                    @endif


                                                    {{-- <a class="btn btn-primary" data-amount="{{$funds->amount}}" data-id="{{$funds->id}}" data-username="{{$funds->user_detail!=null?$funds->user_detail->username:''}}" onclick="opFundWallet(this)" >Edit</a>
                                                    <a class="btn btn-primary " data-type="remark"  data-amount="{{$funds->amount}}" data-id="{{$funds->id}}" data-username="{{$funds->user_detail!=null?$funds->user_detail->username:''}}" onclick="updateRemark(this)" >Remark</a> --}}
                                                    {{-- @else
                                                    N/A
                                                    @endrole --}}
                                                    <!-- </div>   -->
                                                    {{-- @elseif ($row->status=='1')
                                                    <label class="label label-primary">Listing</label>
                                                    @else
                                                    <label class="label label-warning">Pending</label>
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                        <tr align="right">
                                            <td colspan="9" align="right">{!! $nft_purchase_history->render('vendor.default_paginate') !!}</td>
                                        </tr>
                                        @else
                                        <tbody>
                                            <tr align="left">
                                                <td colspan="9">Oops! No Record Found.</td>
                                            </tr>
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="open_counter_offer_modal" class="modal fade open-remark-model" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        {!! Form::open(['route' => ['nft_purchase_request.update', ''], 'method' => 'post', 'class' => 'form-vertical', 'id' => 'counter_offer_form', 'autocomplete' => 'false']) !!}
                        @method('patch')
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><span class="status text-capitalize"></span> Counrter Offer of <span
                                class="username"></span></h4>
                            </div>
                            <div class="modal-body">
                                {!! Form::hidden('request_id', '') !!}
                                {!! Form::hidden('type', '') !!}
                                <div class="form-group">
                                    <label>Counter offer amount:</label>
                                    {!! Form::number('counter_offer_amount', old('counter_offer_amount'), ['min' => '0', 'class' => 'form-control', 'placeholder' => 'Enter counter offer amount']) !!}
                                    <span class="help-block text-danger">{{ $errors->first('counter_offer_amount') }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Remark:</label>
                                    {!! Form::textarea('remark', old('remark'), ['class' => 'form-control', 'placeholder' => 'Enter Note', 'rows' => 4, 'resize' => 'false']) !!}
                                    <span class="help-block text-danger">{{ $errors->first('remark') }}</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a class="btn btn-danger" data-dismiss="modal">Cancel</a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                @endsection
                @section('scripts')
                <script type="text/javascript">
                    var nft_url = "{{ route('nft_purchase_request.update', ['']) }}"
                    var export_url = "{{ route('nft_purchase_request.export') }}";
                    var nft_on_url = "{{ route('nft_on_sale_request.update', ['']) }}"
                    $('.chosen-select').chosen({
                        width: "100%"
                    });
                </script>
                <script src="{{ asset('backend/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
                <script src="{{ asset('backend/js/custom/nftpurchase.js') }}"></script>
                @endsection
