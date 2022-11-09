<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#Id</th>
                <th>Username</th>
                <th>Product</th>
                <th>Amount</th>
                <th>Order ID</th>
                <th>Purchase Date</th>
                <th>Sell Date</th>
                <th>Status</th>
            </tr>
        </thead>
        @php  $i = 1;  @endphp
        <tbody align="left">
            @if (count($nft_purchase_history) > 0)
                @foreach ($nft_purchase_history as $row)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $row->user_detail->username }}</td>
                        <td>{{ $row->nftproduct->name }}</td>
                        <td>
                            {{ number_format($row->amount, 2) }}
                        </td>
                        <td>
                            {{ $row->order_id ?? '' }}
                        </td>
                        <td>{{ $row->purchase_date ? $row->purchase_date->format('Y-m-d') : $row->created_at->format('Y-m-d') }}
                        </td>
                        <td>{{ $row->sell_date ? $row->sell_date->format('Y-m-d') : '-' }}</td>
                        <td>
                            @if ($row->status == '1')
                                <label class="label label-info">Purchased</label>
                            @elseif ($row->status=='2')
                                <label class="label label-success">On Sale</label>
                            @elseif ($row->status=='3')
                                <label class="label label-primary">Sold</label>
                            @else
                               -{{-- <label class="label label-warning">Pending</label> --}}
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
                <td colspan="9" align="right">{!! $nft_purchase_history->render('vendor.default_paginate') !!}</td>
            </tr>
        </tbody>
    </table>
</div>
