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
                <div class="col-xs-12 col-md-6 p-0">NFT On Sell Request</div>
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
                            {{-- <div class="col-xs-12 col-md-2">
                                <div class="form-group">
                                    {!! Form::select('status', ['On Sale' => 'On Sale', 'Listing' => 'Listing', 'Processing' => 'Processing', 'Pending' => 'Pending'], old('status', isset($data['status']) ? $data['status'] : ''), ['class' => 'form-control']) !!}
                                </div>
                            </div> --}}
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
                                @if (isset($nft_onsale_history) && count($nft_onsale_history) > 0)
                                    @php  $i = 1;  @endphp
                                    @foreach ($nft_onsale_history as $row)
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
                                                <td id="onsaleproduct">
                                                    @if ($row->status == 1)
                                                        <label class="label label-primary">Listing</label>
                                                    @elseif ($row->status == 2)
                                                        <label class="label label-success">On Sale</label>
                                                    @else
                                                        <label class="label label-danger">Counter Offer Reject</label>
                                                    @endif
                                                </td>
                                                <td>
                                                        <a class="btn btn-sm btn-success nftonsalereq"
                                                            data-id="{{ $row->id }}" data-type="approve"
                                                            data-value="5" href="#">Approve</a>
                                                        {{-- <a class="btn btn-sm btn-danger nftonsalereq" href="#" data-type="reject"
                                                            data-id="{{ $row->id }}" data-value="3">Reject</a> --}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                    <tr align="right">
                                        <td colspan="9" align="right">{!! $nft_onsale_history->render('vendor.default_paginate') !!}</td>
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
@endsection
@section('scripts')
    <script type="text/javascript">
        var nft_on_url = "{{ route('nft_on_sale_request.update', ['']) }}"
        $('.chosen-select').chosen({
            width: "100%"
        });
    </script>
    <script src="{{ asset('backend/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('backend/js/custom/nftpurchase.js') }}"></script>
@endsection
