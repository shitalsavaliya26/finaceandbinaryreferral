<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Username</th>
                <th>Package</th>
                <th>Amount</th>
                <th>Period</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        @php  $i = 1;  @endphp
        <tbody align="left">
            @if (count($stacking_pool_history) > 0)
                @foreach ($stacking_pool_history as $row)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $row->user_detail->username }}</td>
                        <td>{{ $row->staking_pool_package->name }}</td>
                        <td>
                            {{ number_format($row->amount, 2) }}
                        </td>
                        <td>
                            {{ $row->stacking_period ?? '' }}
                        </td>
                        <td>{{ $row->start_date  ? $row->start_date : ' ' }}</td>
                        <td>{{ $row->end_date ? $row->end_date : ' ' }}</td>
                        <td>
                            @if ($row->status == '2')
                                <label class="label label-warning">Closed</label>
                            @else
                                <label class="label label-success">Active</label>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-info btn-xs" href="{{route('referral_commission.index',['pool' =>$row->staking_pool_package->id])}}">View Commissions</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">Oops! No Record Found.</td>
                </tr>
            @endif
            <tr>
                <td colspan="9" align="right">{!! $stacking_pool_history->render('vendor.default_paginate') !!}</td>
            </tr>
        </tbody>
    </table>
</div>
