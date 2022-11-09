<div class="row mt-4">
  <div class="col-12">
    <table class="table table-dark trading-table text-center table-responsive-sm datas">
      <thead class="table-gradient">
        <tr>
          <th>{{trans('custom.FROM_USER')}}</th>
          <th>{{trans('custom.COMMISSION')}}</th>
          <th>{{trans('custom.STAKING_POOLS')}}</th>
          <th>{{trans('custom.STAKING_POOL_AMOUNT')}}</th>
          <th>{{trans('custom.COMMISSION_WALLET_80')}}</th>
          <th>{{trans('custom.NFT_WALLET_20')}}</th>
          <th>{{trans('custom.DATE')}}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($referral_commission))
        @foreach($referral_commission as $key => $value)
        <tr>
          <td>{{ $value->from_user_detail->username }}</td>
          <td>{{ number_format($value->actual_commission_amount, 2) }}</td>
          <td>{{ (@$value->staking_pool->staking_pool_package->name)?$value->staking_pool->staking_pool_package->name:'-' }}</td>
          <td>{{ (@$value->staking_pool->amount)?$value->staking_pool->amount:'-' }}</td>
          <td>{{ number_format($value->amount, 2) }}</td>
          <td>{{ number_format($value->actual_commission_amount-$value->amount, 2) }}</td>

          <td>{{ date("d/m/Y",strtotime($value->created_at)) }}</td>
        </tr>
        @endforeach
        @else
        <tr >
          <td colspan="10" class="no-records text-center">{{trans('custom.no_data_found')}}</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
<div class="row align-items-center mt-5">
  <div class="col-12 text-right">
    <div class="text-secondary">
      <div class="referral-commission-second-ajax-report">
        @if($referral_commission->count() > 0){{ $referral_commission->render() }}@endif
      </div>
    </div>
  </div>
</div>