<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Username</th>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Order ID</th>
                <th>Transaction ID</th>
                <th>Status</th>
            </tr>
        </thead>
        @php  $i = 1;  @endphp
        <tbody align="left">
            @if(count($nft_wallets_payment_history) > 0)
            @foreach($nft_wallets_payment_history as $row)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$row->user_detail->username}}</td>
                <td>{{($row->action_date) ? $row->action_date : $row->created_at }}</td>
                <td>
                    @if($row->type == 0)
                    USDT
                    @elseif($row->type == 1)
                    Malasian Payment
                    @elseif($row->type == 2)
                    CoinPayment
                    @elseif($row->type == 3)
                    Admin Added
                    @elseif($row->type == 4)
                    Admin Reduced
                    @else
                    @endif
                </td>
                <td>
                    {{number_format($row->amount,2)}}
                </td>
                <td>
                    {{$row->order_id ?? ''}}
                    {{-- {{($row->type == 8) ? $row->order_id : ''}} --}}
                </td>
                <td>
                    {{$row->transaction_id ?? ''}}
                    {{-- {{($row->type == 8) ? $row->transaction_id : ''}} --}}
                </td>
                <td >
                @if($row->type == 3)
                    <label class="label label-primary">Added</label>
                @else
                    @if($row->status=='1')
                    <label class="label label-primary">Approved</label>
                    @elseif($row->status=='2')
                    <label class="label label-danger">Rejected</label>
                    @else
                    <label class="label label-warning">Pending</label>
                    @endif
                @endif
                </td>
            </tr>               
            @endforeach                            
            @else
            <tr>
                <td colspan="9">Oops! No Record Found..</td>
            </tr>
            @endif
            <tr>
                <td colspan="9" align="right">{!! $nft_wallets_payment_history->render('vendor.default_paginate') !!}</td>
            </tr>
        </tbody>
    </table>
</div>