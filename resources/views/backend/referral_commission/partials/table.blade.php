<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Username</th>
                <th>From Username</th>
                <th>Package</th>
                <th>Amount</th>
            </tr>
        </thead>
        @php  $i = 1;  @endphp
        <tbody align="left">
            @if (count($referral_commission) > 0)
                @foreach ($referral_commission as $row)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $row->user_detail->username ?? ""}}</td>
                        <td>{{ $row->from_user_detail->username ?? "" }}</td>
                        <td>{{ $row->staking_pool->staking_pool_package->name ?? "" }}</td>
                        <td>
                            {{ number_format($row->amount, 2) }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">Oops! No Record Found.</td>
                </tr>
            @endif
            <tr>
                <td colspan="9" align="right">{!! $referral_commission->render('vendor.default_paginate') !!}</td>
            </tr>
        </tbody>
    </table>
</div>
