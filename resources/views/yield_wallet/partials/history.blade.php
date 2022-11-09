<table class="table table-dark trading-table text-center">
  <thead class="table-gradient">
    <tr>
      <th>{{ trans('custom.date')}}</th>
      <th>{{ trans('custom.amount')}}</th>
      <th>{{ trans('custom.description')}}</th>
      <th>{{ trans('custom.type')}}</th>
    </tr>
  </thead>
  <tbody>
    @if(count($history))
    @foreach($history as $key => $value)
    <tr>
      <td>{{date("d-m-Y",strtotime($value->created_at))}}</td>
      <td>${{ number_format($value->amount, 2)}}</td>
      <td>{{ $value->description}}</td>
      @if($value->type == 0)
      <td class="text-danger">{{trans('custom.reduced')}}</td>
      @elseif($value->type == 2)
      <td class="text-success">{{trans('custom.admin_added')}}</td>
      @else
      <td class="text-success">{{trans('custom.added')}}</td>
      @endif
    </tr>
    @endforeach
    @else
    <tr >
        <td colspan="10" class="no-records text-center">{{trans('custom.no_data_found')}}</td>
    </tr>
    @endif
  </tbody>
</table>