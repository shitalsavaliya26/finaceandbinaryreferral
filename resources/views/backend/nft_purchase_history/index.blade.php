@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
    <link href="{{ asset('backend/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>
                <div class="col-xs-12 col-md-4 p-0">NFT Purchase History</div>
                <div class="col-xs-12 col-md-8 text-right">
                    {{-- @role('admin') --}}
                    <a class="btn  btn-info" onclick="exportnftpurchasehistoryFunction()">Export</a>
                    {{-- @endrole --}}
                </div>
            </h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12 text-left m-b-md">
                {!! Form::open(['route' => 'nft_purchase_history.index', 'class' => 'form-inline', 'method' => 'get', 'id' => 'filter_nft_data_ajax']) !!}
                <div class="col-sm-12 p-0">
                    <div class="form-group">
                        <input type="text" value="{{ isset($data['username']) ? $data['username'] : '' }}" name="username"
                            placeholder="Search Username" class="form-control input-sm" id="search-input">
                    </div>
                    <div class="input-daterange input-group" id="datepicker">
                        {!! Form::text('start', old('start', isset($data['start']) ? $data['start'] : ''), ['class' => 'input-sm form-control', 'placeholder' => 'Start Date', 'readonly' => 'true']) !!}
                        <span class="input-group-addon">to</span>
                        {!! Form::text('end', old('end', isset($data['end']) ? $data['end'] : ''), ['class' => 'input-sm form-control', 'placeholder' => 'End Date', 'readonly' => 'true']) !!}
                    </div>
                    {{-- <div class="form-group">
                        {!! Form::select('status', ['1' => 'Processing', '2' => 'On Sale', '3' => 'Listing', '4' => 'Pending'], old('status', @$data['status']), ['class' => 'form-control', 'placeholder' => 'All Status']) !!}
                    </div> --}}
                    <div class="form-group">
                        {!! Form::select('status', ['1' => 'Purchased', '2' => 'On Sale', '3' => 'Sold'], old('status', @$data['status']), ['class' => 'form-control', 'placeholder' => 'All Status']) !!}
                    </div>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Search</button>
                    <a class="btn btn-danger" href="{{ route('nft_purchase_history.index') }}">Clear</a>
                </div>
                <label id="start-error" class="error" for="start"></label>
                <label id="end-error" class="error" for="end"></label>
                {!! Form::close() !!}
            </div>

            <div class="col-lg-12">
                <div class="ibox ">
                    <h4>Total Amount:<span class="border-bottom page-heading">$ {{ $total_amount }}</span></h4>
                    <div class="ibox-content bg-dark-blue">
                        <div class="include-html">
                            @include('backend.nft_purchase_history.partials.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var exportnfth_url = "{{ route('nft_purchase_history.export') }}";
    </script>
    <script src="{{ asset('backend/js/custom/nftpurchase.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{asset('backend/js/custom/reports.js')}}"></script>
@endsection
