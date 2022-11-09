@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-3 p-0">NFT Products</div>
            <div class="pull-right">
                <a class="btn btn-success btn-sm" href="{{ route('nft-product.create')}}"><i class="fa fa-add-user"></i> Create New NFT Product</a>
            </div>
        </h2>
    </div>
</div>
@php
    $select = [];
    $owner = [];
    foreach($products as $value){
    $select[$value->nftcategory->id] = $value->nftcategory->name;
        foreach($value->nftpurchasehistory as $value1){
        $owner[$value1->user_id] = $value1->user_detail->username;
        }
    }
    $owner += ['admin' => "Admin"];
@endphp
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 text-left m-b-md">
            {!! Form::open(['route' => 'nft-product.index','class'=>'form-inline','method'=>'get','id'=>'filter_request']) !!}
                <div class="col-sm-12 p-0">     
                    <div class="form-group">                                
                        <input type="text"  value="{{isset($data['keyword'])?$data['keyword']:''}}" name="keyword" placeholder="Search By Nft Name" class="form-control" id="search-input">
                    </div>
                    <div class="form-group">                                
                        {!! Form::select('category', $select,old('category',@$data['category']), ['class'=>'form-control','placeholder'=>'Category']) !!}
                    </div>
                    <div class="form-group">                                
                        {!! Form::select('product_status',['Normal'=>'Normal','Sold'=>'Sold','Hidden'=>'Hidden'],old('product_status',@$data['product_status']),['class'=>'form-control','placeholder'=>'Product Status']) !!}
                    </div>                                                        
                    <div class="form-group">                                
                        {!! Form::select('owner',$owner,old('owner',@$data['owner']),['class'=>'form-control','placeholder'=>'Owner']) !!}
                    </div>
                            
                    <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Search</button>
                    <a class="btn btn-danger" href="{{route('nft-product.index')}}">Clear</a>
                </div>
                 <label id="start-error" class="error" for="start"></label>
                <label id="end-error" class="error" for="end"></label>
            {!! Form::close() !!}   
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content bg-dark-blue">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Owner</th>
                                    {{-- <th>Description</th> --}}
                                    <th>Status</th>
                                    <th>Product Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($products) > 0)
                                @php
                                $i = ($products->currentpage() - 1) * $products->perpage() + 1;
                                @endphp
                                @foreach($products as  $key=>$row)
                                @php
                                $product = \App\Models\NftPurchaseHistory::where(['product_id' => $row->id])->whereIn('status',[1,2])->count(); 
                                $history = \App\Models\NftPurchaseHistory::where(['product_id' => $row->id])->whereIn('status',[1,2])->first(); 

                                @endphp
                                <tr>

                                    <td>{{$i++}}</td>
                                    <td>
                                        {{$row->name}}  
                                    </td>
                                    <td>
                                        {{$row->nftcategory->name}}  
                                    </td>
                                    <td>
                                        @if ($product > 0) {{$history->user_detail->username}}  @else Admin @endif
                                    </td>
                                    {{-- <td>
                                        {!! \Illuminate\Support\Str::limit($row->description,50) !!} 
                                    </td> --}}
                                    <td>
                                        @if($row->status=='active')
                                        <label class="label label-primary">Active</label>   
                                        @else
                                        <label class="label label-danger">In-active</label>   

                                        @endif
                                    </td>
                                    <td>
                                        @if($row->product_status=='Normal')
                                        <label class="label label-primary">Normal</label>   
                                        @elseif ($row->product_status=='Sold')
                                        <label class="label label-danger">Sold</label> 
                                        @elseif ($row->product_status=='Withdrawn')
                                        <label class="label label-danger">Withdrawn</label> 
                                        @else
                                        <label class="label label-warning">Hidden</label>   
                                        @endif
                                    </td>
                                    <td>

                                        @if ($product > 0)
                                        @if($row->product_status!='Withdrawn')
                                        <a class="btn btn-primary btn-xs" href="{{route('nft-product.edit',[$row->id])}}"><i class="fa fa-edit"></i></a>
                                        <!-- <p>Owned by {{$history->user_detail->username}}</p> -->
                                        <a class="btn btn-info btn-xs d-inline" href="{{route('trading-history.show',[$row->id])}}"><i class="fa fa-list"></i></a>
                                        @endif
                                        @else
                                        {!! Form::open(['route' => ['nft-product.update',$row->id],'onsubmit'=>"return confirmDelete(this,'Are you sure to want delete this product ?')",'class'=>'d-inline']) !!}
                                        <a class="btn btn-primary btn-xs" href="{{route('nft-product.edit',[$row->id])}}"><i class="fa fa-edit"></i></a>
                                        @method('delete')
                                        <button class="btn btn-danger  btn-xs" type="submit" ><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-info btn-xs d-inline" href="{{route('trading-history.show',[$row->id])}}"><i class="fa fa-list"></i></a>
                                        {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>                                        
                                @endforeach                            
                                @else
                                <tr>
                                    <td>Oops! No Record Found.</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="9" align="right">{!! $products->render('vendor.default_paginate') !!}</td>
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