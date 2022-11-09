<div id="fund_wallet" class="tab-pane active">
    <div class="panel-body">
        <h3 class="title">NFT wallet History <a class="btn btn-success pull-right" data-toggle="modal" data-target="#fundWallet"><i class="fa fa-edit"></i> Edit NFT Wallet</a></h3>
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>#Id</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Detail</th>
                    <th>Date</th>
                </tr>
            
                @if(isset($nft_wallets) && count($nft_wallets)>0)
                    @php
                        $i = ($nft_wallets->currentpage() - 1) * $nft_wallets->perpage() + 1;
                    @endphp
                    @foreach($nft_wallets as $funds)
                    <tbody>
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{number_format($funds->amount,'2')}}</td>
                        <td>{{$funds->type==0?'Reduced':($funds->type==2?'Added By Admin':"Added")}}</td>
                        <td>{{$funds->description}}</td>
                        <td>{{$funds->createdDate}}</td>
                    </tr>
                    </tbody>                                        
                    @endforeach
                    <tfoot>
                        <tr align="right">
                            <td colspan="6">{!! $nft_wallets->render('vendor.default_paginate') !!}</td>
                        </tr>
                    </tfoot>
                @else
                <tbody >
                    <tr>
                        <td colspan="6">Oops! No Record Found..</td>
                    </tr>
                </tbody >
                @endif
        </table>
    </div>
</div>
<!-- Modal -->
<div id="fundWallet" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open(['route'=>'nft-wallet-history.store','method'=>'post','class'=>'form-vertical','id'=>'userall_wallets','autocomplete'=>'false']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit NFT Wallet [{{$user->name}}]</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="user_id" value="{{$user->id}}" />
                    <label>Amount</label> 
                     {!! Form::text('amount',old('amount',($user->userwallet!=null?$user->userwallet->nft_wallet:"0")),['min'=>'0','class'=>'form-control','placeholder'=>'Enter Amount']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                </div>
                <div class="form-group">
                    <label>Note:</label> 
                     {!! Form::textarea('description',old('description'),['class'=>'form-control','placeholder'=>'Enter Note','rows'=>4,'resize'=>'false']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
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