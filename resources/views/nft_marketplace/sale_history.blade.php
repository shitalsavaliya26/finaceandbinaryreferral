<table class="table table-dark trading-table text-center table-responsive-sm">
    <thead class="table-gradient">
        <tr>
            {{-- <th>NFT</th>
            <th>NAME</th>
            <th>AMOUNT</th>
            <th>ORDER ID</th>
            <th>DATE</th>
            <th>STATUS</th>
            <th></th> --}}

            <th>{{trans('custom.NFT')}}</th>
            <th>{{trans('custom.NAME')}}</th>
            <th>{{trans('custom.AMOUNT')}}</th>
            <th>{{trans('custom.ORDER_ID')}}</th>
            <th>{{trans('custom.DATE')}}</th>
            <th>{{trans('custom.STATUS')}}</th>
            <th>{{trans('COUNTER OFFER')}}</th>
            {{-- <th></th> --}}
        </tr>
    </thead>
    <tbody>
        @if(count($nftsalehistory) > 0)
		@foreach($nftsalehistory as $value)
		{{-- <tr>
			<td>${{ number_format($value->purchase_amount, 2) }}</td>
			<td>{{ date("d/m/Y",strtotime($value->created_at)) }}</td>
		</tr> --}}
        <tr>
            <td style="max-width: 100px;">
                    <img src="{{ asset($value->nftproduct->image) }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="" id="salehistoryimage" style="width: 100%;">
            </td>
            <td>{{ $value->nftproduct->name }}</td>
            <td>${{ number_format($value->sale_amount, 2) }}</td>
            <td>{{ $value->order_id }}</td>
            <td>{{ date("d/m/Y",strtotime($value->created_at)) }}</td>
            @if ($value->status == 1)
            <td class="text-warning">{{trans('custom.LISTING')}}</td> 
            @elseif ($value->status == 2)
            <td class="text-info">{{trans('custom.ON_SALE')}}</td>
            @elseif ($value->status == 3)
            <td class="text-danger">{{trans('custom.DECLINED')}}</td>
            @elseif ($value->status == 4)
            <td class="text-danger">{{trans('custom.COUNTER_OFFER_DECLINED')}}</td>
            @elseif ($value->status == 5)
            <td class="text-warning">{{trans('custom.PROCESSING')}}</td>
            @elseif ($value->status == 6)
            <td class="text-secondary">{{trans('custom.COUNTER_OFFER_CREATED')}}</td>
            @elseif ($value->status == 7)
            <td class="text-success">{{trans('custom.SOLD')}}</td>
            @else
                -
            @endif
            <td>
                @if ($value->counter_offer_status == 1)
                <a href="javascript:void(0)" onclick="viewcounteroffer({{ $value->id }})">{{ trans('custom.view')}}</a>
                @else
                    -
                @endif
                {{-- <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt=""> --}}
            </td>
        </tr>
		@endforeach
		@else
		<tr>
		    <td colspan="10" class="no-records text-center">{{trans('custom.no_data_found')}}</td>
		</tr>
		@endif
        
        {{-- <tr>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group559.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
            <td>BULL KONG #7097</td>
            <td>$30,000.00</td>
            <td>39475910</td>
            <td>3/02/2021</td>
            <td class="text-info">PENDING</td>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group553.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
            <td>BULL KONG #7097</td>
            <td>$30,000.00</td>
            <td>39475910</td>
            <td>3/02/2021</td>
            <td class="text-warning">SOLD</td>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group559.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
            <td>BULL KONG #7097</td>
            <td>$30,000.00</td>
            <td>39475910</td>
            <td>3/02/2021</td>
            <td class="text-danger">REJECT</td>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group553.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
            <td>BULL KONG #7097</td>
            <td>$30,000.00</td>
            <td>39475910</td>
            <td>3/02/2021</td>
            <td class="text-warning">SOLD</td>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group559.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
            <td>BULL KONG #7097</td>
            <td>$30,000.00</td>
            <td>39475910</td>
            <td>3/02/2021</td>
            <td class="text-info">PENDING</td>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group553.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
            <td>BULL KONG #7097</td>
            <td>$30,000.00</td>
            <td>39475910</td>
            <td>3/02/2021</td>
            <td class="text-danger">REJECT</td>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
        </tr>
        <tr>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group559.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
            <td>BULL KONG #7097</td>
            <td>$30,000.00</td>
            <td>39475910</td>
            <td>3/02/2021</td>
            <td class="text-warning">SOLD</td>
            <td>
                <img src="{{ asset('assets/images/assets/Sell_NFT/Group554.png') }}"
                    class="img-fluid rounded-0 w-auto h-auto" alt="">
            </td>
        </tr> --}}
    </tbody>
</table>
<div class="col-12 text-right">
	<div class="text-secondary">
		<div class="second-ajax-pag ">
			@if($nftsalehistory->count() > 0){{ $nftsalehistory->render() }}@endif   
		</div>
	</div>
</div>