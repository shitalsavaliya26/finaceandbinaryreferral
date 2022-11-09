<div class="row mt-4">
  <div class="col-12">
    <table class="table table-dark trading-table text-center table-responsive-xl">
      <thead class="table-gradient">
        <tr>
          <th>{{trans('custom.SALES_LEFT')}}</th>
          <th>{{trans('custom.SALES_RIGHT')}} </th>
          <th> {{trans('custom.CARRY_FORWARD_LEFT')}}</th>
          <th>{{trans('custom.CARRY_FORWARD_RIGHT')}}</th>
          <th>{{trans('custom.DAILY_LIMIT')}}</th>
          <th>{{trans('custom.PERCENTAGE')}}</th>
          <th>{{trans('custom.COMMISSION_EARNED')}} </th>
          <th>{{trans('custom.COMMISSION_WALLET')}} </th>
          <th> {{trans('custom.NFT_WALLET')}}</th>
          <th>{{trans('custom.DATE')}}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($paring_commissions))
        @foreach($paring_commissions as $key => $value)
        <tr>
          <td>{{ $value->left_sale }}</td>
          <td>{{ $value->right_sale }}</td>
          <td>
            @if($value->commission_got_from == 'right')
              {{ $value->carry_forward }}
            @else
            -
            @endif
          </td>
          <td>
            @if($value->commission_got_from == 'left')
              {{ $value->carry_forward }}
            @else
            -
            @endif
          </td>
          <td>{{ $value->daily_limit}}</td>
          <td>{{ $value->pairing_percent}}%</td>
          <td>{{ '$'.$value->actual_commission_amount}}</td>
          <td>{{ '$'.$value->pairing_commission}}</td>
          <td>{{ '$'.($value->actual_commission_amount-$value->pairing_commission)}}</td>

          <td>{{ date("d/m/Y",strtotime($value->created_at)) }}</td>
        </tr>
        @endforeach
        @else
        <tr>
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
      <div class="nodes-management-second-ajax-report">
        @if($paring_commissions->count() > 0){{ $paring_commissions->render() }}@endif
      </div>
    </div>
  </div>
</div>