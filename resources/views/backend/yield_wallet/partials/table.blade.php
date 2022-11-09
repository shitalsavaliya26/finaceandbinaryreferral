<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        @php  $i = 1;  @endphp
        <tbody align="left">
            @if(count($yield_wallet_payment) > 0)
            @foreach($yield_wallet_payment as $row)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$row->user_detail->username}}</td>
                <td>
                    {{number_format($row->amount,2)}}
                </td>
                <td>{{($row->created_at) ? $row->created_at : $row->created_at }}</td>
                <td >
                    @if($row->type == 2)
                    <label class="label label-primary">Added</label>
                    @else
                    <label class="label label-danger">Reduce</label>
                    @endif
                </td>
            </tr>               
            @endforeach                            
            @else
            <tr>
                <td colspan="9">Oops! No Record Found.</td>
            </tr>
            @endif
            <tr>
                <td colspan="9" align="right">{!! $yield_wallet_payment->render('vendor.default_paginate') !!}</td>
            </tr>
        </tbody>
    </table>
</div>