<table class="table table-dark trading-table text-center table-responsive-sm table-pisprebate">
    <thead class="table-gradient">
        <tr>
            <th>{{trans('custom.NFT')}}</th>
            <th class="text-uppercase">{{trans('custom.title')}}</th>
            <th class="text-uppercase">{{trans('custom.NFT_CATEGORY')}}</th>
            <th>{{trans('custom.DATE')}}</th>
            <th>{{trans('custom.STATUS')}}</th>
            <th class="text-uppercase">{{trans('custom.remarks')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(count($history))
        @foreach($history as $key => $value)  
        <tr>
            <td style="max-width: 100px;">
                <img src="{{ asset($value->nftproduct->image) }}"
                class="img-fluid rounded-0 w-auto h-auto" alt="" id="salehistoryimage" style="width: 100%;">
            </td>
            <td>{{ $value->nftproduct->name }}</td>
            <td>{{ $value->nftproduct->nftcategory->name }}</td>
            <td>{{date("d/m/Y",strtotime($value->created_at))}}</td>
            @if($value->status == 0)
            <td class="text-warning">{{trans('custom.pending')}}</td>
            @elseif($value->status == 1)
            <td class="text-success">{{trans('custom.approved')}}</td>
            @elseif($value->status == 2)
            <td class="text-danger">{{trans('custom.rejected')}}</td>
            @else
            <td class="text-danger">{{trans('custom.verifying')}} | 
                <a class="m-l-xs" href="{{route('nftresendEmail',$value->usdt_verification_key)}}">{{trans('custom.resend_email')}}</a>
            </td>
            @endif
            @if($value->status == 2)
            <td>
                {{$value->remarks}}
            </td>
            @else
            <td>-</td>
            @endif
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="no-records text-center">{{trans('custom.no_data_found')}}</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="col-12 text-right mt-5">
	<div class="text-secondary">
		<div class="second-ajax-pag ">
			@if($history->count() > 0){{ $history->render() }}@endif   
		</div>
	</div>
</div>