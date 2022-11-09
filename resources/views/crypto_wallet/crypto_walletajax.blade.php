<div class="row mt-2">
  <div class="col-12">
    <h4 class="text-white pb-3">{{ trans('custom.crypto_wallet_history')}}</h4>
  </div>
  <div class="col-12">
    <div class="table-responsive table-history">
      <table class="table table-dark trading-table text-center table-responsive-sm">
        <thead class="table-gradient">
          <tr>
            <th>{{ trans('custom.date')}}</th>
            <th>{{ trans('custom.amount')}}</th>
            <th>{{ trans('custom.type')}}</th>
            <th>{{ trans('custom.payment_proof')}}</th>
            <th>{{ trans('custom.description')}}</th>
            <th>{{ trans('custom.status')}}</th>
            <th>&nbsp;</th>  
          </tr>
        </thead>
        <tbody>
          @if(count($cryptowallet))
          @foreach($cryptowallet as $key => $value)
          <tr>
            <td>{{date("d/m/Y",strtotime($value->created_at))}}</td>
            <td>${{ number_format($value->amount, 2)}}</td>
            @if($value->type == 0)
            <td>USDT</td>
            @else
            <td>-</td>
            @endif
            @if($value->trans_slip)
            <td><a target="_blank" href="{{asset('uploads/upload_bank_proof/'.$value->trans_slip)}}">{{ trans('custom.view')}}</a></td>
            @else
            <td>-</td>
            @endif
            <td>{{ ($value->remark)? $value->remark:'-'}}</td>
            @if($value->status == 0)
            <td class="text-warning">{{ trans('custom.pending')}}</td>
            @endif
            @if($value->status == 1)
            <td class="text-success">{{ trans('custom.approved')}}</td>
            @endif
            @if($value->status == 2)
            <td class="text-danger">{{ trans('custom.rejected')}}</td>
            @endif
            <td class="text-danger">
            @if($value->status == 1 && $value->certificate_id != '')
            <a href="{{asset('uploads/pdf/'.$value->certificate_id.'.pdf')}}" target="_blank" class="text-danger printReport">
              Certificate
            </a>
            @endif
            </td>
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
</div>
<div class="row align-items-center mt-5">
  <div class="col-12 text-right">
    <div class="text-secondary">
      <div class="second-ajax-pag">
        @if(count($cryptowallet) > 0){{$cryptowallet->render() }}@endif
      </div>
    </div>
  </div>
</div>