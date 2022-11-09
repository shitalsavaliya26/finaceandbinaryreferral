@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-2 p-0">Manage Users</div>
            <div class="col-xs-12 col-md-10 text-right">
                 {!! Form::open(['route' => 'user.index','class'=>'form-inline form-fix-height','method'=>'get']) !!}
                <div class="col-sm-8 pl-0 col-xs-12">
                    <div class="form-group">                                
                        <input type="text"  value="{{isset($data['keyword'])?$data['keyword']:''}}" name="keyword" placeholder="Search By Full Name,Username and Email" class="form-control input-sm" id="search-input">
                    </div> 
                    <div class="form-group">                                
                        {!! Form::select('promo_account',['1'=>'Yes','2'=>'No'],old('promo_account',@$data['promo_account']),['class'=>'form-control','placeholder'=>'All']) !!}
                    </div>       
                    {{-- <div class="form-group">                                
                         {!! Form::select('group_id',$groups,old('group_id',@$data['group_id']),['class'=>'form-control  input-sm','placeholder'=>'All Groups','id'=>"search-select"]) !!}
                    </div>             --}}
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-filter"></i> Search</button>
                    <a class="btn btn-danger btn-sm" href="{{route('user.index')}}">Clear</a>
                </div>                              
                {!! Form::close() !!}
                {{-- @role('admin') --}}
                <div class="col-sm-4 pl-0 col-xs-12">
                     {{-- <a class="btn btn-warning btn-sm btn-xs-block " href="javascript:void(0)" data-toggle="modal" data-target="#fundWallet"><!-- <i class="fa fa-user-plus"></i> --> Add Fund</a> --}}
                    <a class="btn btn-success btn-sm btn-xs-block " href="{{route('user.create')}}"><!-- <i class="fa fa-user-plus"></i> --> Add New User</a>
                    {{-- <a class="btn btn-info btn-sm btn-xs-block " href="{{route('user.mt4_request')}}"><i class="fa fa-cloud-download"></i> MT5 Requests</a> --}}
                </div>
                {{-- @endrole --}}
            </div>
               
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
                                    <th width="5%">id</th>
                                    <th width="15%">Fullname</th>
                                    {{-- <th width="5%">Group</th> --}}
                                    <th width="15%">Username</th>
                                    <th width="23%">Email</th>
                                    {{-- <th width="5%">MT5 Id</th> --}}
                                    {{-- <th width="6%">Crypto Wallet</th> --}}
                                    {{-- <th width="6%">MT5 Topup<br>wallet</th> --}}
                                    {{-- <th width="8%">Total Topup<br>Value</th> --}}
                                    {{-- <th width="5%">Package</th> --}}
                                    <th width="5%">Country</th>
                                    <th width="15%">Sponsor</th>
                                    <th>PROMO</th>
                                    <th width="10%">Date</th>
                                    {{-- @role('admin') --}}
                                    <th width="25%">Actions</th>
                                    {{-- @endrole --}}
                                </tr>
                            </thead>
                            @php  $i = 1;  @endphp
                            <tbody>
                                @if(count($users) > 0)
                                @foreach($users as $row)
                                <tr class="row-user-{{$row->id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$row->name}}</td>
                                    {{-- <td><small>{{@$row->group->name}}</small></td>                              --}}
                                    <td class="break-word "><a class="" href="{{route('user.show',[$row->username])}}">{{$row->username}}</a></td>
                                    <td class="break-word "><a class="" href="{{route('user.show',[$row->username])}}">{{$row->email}}</a></td>                             
                                    {{-- <td>{{@$row->mt4_user_id}}</td>                              --}}
                                    {{-- <td >
                                        <a class="btn-fund-wallet" data-user_id="{{$row->id}}" data-user="{{$row->username}}" data-amt='{{$row->userwallet!=null?$row->userwallet->crypto_wallet:"0.00"}}'>
                                        {{$row->userwallet!=null?number_format($row->userwallet->crypto_wallet,2):"0.00"}}
                                        <!-- <i class="fa fa-edit"></i> --></a>
                                    </td> --}}
                                    {{-- <td>
                                        {{$row->userwallet!=null?number_format($row->userwallet->mt_topup_wallet,2):"0.00"}}
                                    </td> --}}
                                    {{-- <td>
                                        <a class="btn-total_capital" data-user_id="{{$row->id}}" data-user="{{$row->username}}" data-amt='{{$row->total_capital!=null?$row->total_capital:"0"}}'>
                                        {{$row->total_capital?$row->total_capital:"0"}}
                                        <!-- <i class="fa fa-edit"></i> --></a> 
                                    </td> --}}
                                    {{-- <td>{{$row->package_detail!=null?$row->package_detail->name:"-"}}</td> --}}
                                    <td>{{$row->country!=null?$row->country->country_name:"-"}}</td>
                                    <td>{{$row->sponsor!=null?$row->sponsor->username:"-"}}</td>
                                    <td>{{($row->promo_account == 1)? 'Yes' : 'No'}}</td>
                                    <td>{{date('Y-m-d',strtotime($row->created_at))}}</td>
                                    {{-- @role('admin') --}}
                                    <td  class="font-s-14" width="20%">
                                        {!! Form::open(['route' => ['user.update',$row->id],'onsubmit'=>"return confirmDelete(this,'Are you sure to want delete ?')",'id'=>'form-user-'.$row->id]) !!}                                    
                                        <a class="" data-toggle="tooltip" title="Edit User detail" href="{{route('user.edit',[$row->id])}}">Edit</a> |                                 
                                        @method('delete')
                                        <div class="dropdown">
                                        <a class="" data-toggle="tooltip" title="Delete User" onclick="$('#form-user-{{$row->id}}').submit()" >Delete</a> &nbsp;
                                        <a class="dropdown-toggle " href="#" id="dropdownMenuLink{{$row->id}}" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                                        {!! Form::close() !!}
                                        <ul class="dropdown-menu m-t-xs">
                                           <li><a class="" href="{{route('crypto-wallet-history.show',[$row->id])}}">Wallet History</a></li>
                                           <li><a class="" href="{{route('referral_commission.index',['user'=>$row->id])}}">
                                            Referral Commission
                                            </a></li>
                                        {{-- <li><a class=" btn-upgrade-package" data-package="{{$row->package_detail!=null?$row->package_detail->id:'0'}}" data-id="{{$row->id}}"  href="#" >Upgrade Package</a></li> --}}
                                            {{-- <li><a class=" btn-upgrade-package resend_welcome_email"  href="{{route('user.resend_welcome_email',$row->id)}}" >Resend Welcome Email</a></li> --}}
                                            {{-- @if($row->mt4_user_id) --}}
                                            {{-- <li><a class=" btn-upgrade-package resend_mt5_email" data-id="{{$row->id}}"  href="{{route('user.resend_mt5_email',$row->id)}}" >Resend MT5 Email</a></li>
                                            @endif--}}
                                        </ul>
                                        </div> 
                                    </td>
                                    {{-- @endrole --}}
                                </tr>           
                                @endforeach                            
                                @else
                                <tr class="my-3">
                                    <td colspan="14">Oops! No Record Found.</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="14" align="right">{!! $users->render('vendor.default_paginate') !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
{{-- @role('admin')
<div id="fundWallet" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open(['route'=>'user.add_fund_userwallet','method'=>'post','class'=>'fix-input form-vertical','id'=>'add_fund_userwallet','autocomplete'=>'false']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Fund Wallet <span class="username"></span></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="user_id" name="user_id" value="" />
                    <label>Add Amount</label> 
                     {!! Form::number('amount',old('amount'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Amount']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                </div>
                 <div class="form-group">
                    <label>Note:</label> 
                     {!! Form::textarea('description',old('description'),['class'=>'form-control','placeholder'=>'Enter Note','rows'=>4,'resize'=>'false']) !!}
                    <span class="help-block text-danger">{{ $errors->first('description') }}</span>
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
<!-- Modal -->
<div id="mtTopupWallet" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
           
        </div>
    </div>
</div>
<!-- Modal -->
<div id="total_capital" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open(['url'=>'','method'=>'post','class'=>'form-vertical','id'=>'total_capital_form','autocomplete'=>'false']) !!}
            @method('patch')
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Topup Value</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="user_id" value="" />
                    <label>Total Topup Value</label> 
                     {!! Form::number('total_capital',old('total_capital'),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Total Topup Value','min'=>'0']) !!}
                    <span class="help-block text-danger">{{ $errors->first('total_capital') }}</span>
                </div>
                <div class="form-group">
                    <label>Note:</label> 
                     {!! Form::textarea('description',old('description'),['class'=>'form-control','placeholder'=>'Enter Note','rows'=>4,'resize'=>'false']) !!}
                    <span class="help-block text-danger">{{ $errors->first('description') }}</span>
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
<!-- Modal -->
<div id="upgradePackage" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open(['route'=>'user_upgrade_package','method'=>'post','class'=>'form-vertical','class'=>'fix-input','id'=>'upgradePackageId','autocomplete'=>'false']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Upgrade Package [<span class="username"></span>]</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-5 pl-0">
                <div class="form-group">
                    <input type="hidden" name="user_id" value="" />
                    <label>Fund Wallet</label> 
                     {!! Form::text('fund_amount',old('amount'),['min'=>'0','class'=>'form-control','readonly'=>true,'placeholder'=>'Enter Amount']) !!}
                </div>
                </div>
                <div class="col-lg-7 pr-0">
                <div class="form-group">
                    <input type="hidden" name="user_id" value="" />
                    <label>MT5 Topup Wallet</label> 
                     {!! Form::text('mt_topup',old('mt_topup'),['min'=>'0','class'=>'form-control','readonly'=>true]) !!}
                </div>
                </div>
                <div class="form-group">
                    <label>User Package</label> 
                     {!! Form::select('package',$packages,old('description'),['class'=>'form-control','placeholder'=>'No Package','rows'=>4,'resize'=>'false']) !!}
                    <span class="help-block text-danger">{{ $errors->first('description') }}</span>
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
@endrole
<div id="add_fund_wallet" class="modal fade open-remark-model" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            {!! Form::open(['route'=>['mt4_wallet_withdrawal_status_update',''],'method'=>'post','class'=>'form-vertical','id'=>'mt4_withdrawal_request_form','autocomplete'=>'false','files'=>true]) !!}
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="status text-capitalize"></span> withdraw request of <span class="username"></span></h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="hidden" name="request_id" value="" />
                        <input type="hidden" name="status" value="" />
                        <label>Approved Amount:</label> 
                        {!! Form::number('approved_amount',old('approved_amount'),['class'=>'form-control','placeholder'=>'Approved Amount']) !!}
                        <span class="help-block text-danger">{{ $errors->first('approved_amount') }}</span>
                    </div>
                    <div class="form-group">
                        <label>Transaction Id:</label> 
                        {!! Form::text('transaction_id',old('transaction_id'),['class'=>'form-control','placeholder'=>'Transaction Id']) !!}
                        <span class="help-block text-danger">{{ $errors->first('transaction_id') }}</span>
                    </div>
                </div>
                 <div class="col-lg-6">
                <div class="form-group">
                    <label>Remark:</label> 
                     {!! Form::textarea('remark',old('remark'),['class'=>'form-control','placeholder'=>'Enter Note','rows'=>4,'resize'=>'false']) !!}
                    <span class="help-block text-danger">{{ $errors->first('remark') }}</span>
                </div> 
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Submit</button>
                <a  class="btn btn-danger" data-dismiss="modal">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div> --}}
@endsection
@section('scripts')
{{-- <script type="text/javascript"> var updateCapitalBalace = "{{route('user.update',[''])}}"</script> --}}
<script type="text/javascript" src="{{asset('backend/js/custom/member.js')}}"></script>
{{-- <script type="text/javascript">
    $('.resend_welcome_email').click(function(e){
        if($(this).hasClass('disabled')){
            e.preventDefault();

        }
        $(this).addClass('disabled');
    });
    $('.resend_mt5_email').click(function(e){
        if($(this).hasClass('disabled')){
            e.preventDefault();

        }
        $(this).addClass('disabled');
    });
</script> --}}
@endsection