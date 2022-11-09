<table class="table table-dark trading-table text-center mb-4">
	<thead class="table-gradient">
		<tr>
			<th>{{ __('custom.amount')}}</th>
			<th>{{ __('custom.date')}}</th>
		</tr>
	</thead>
	<tbody>
		@if(count($purchaseHistory) > 0)
		@foreach($purchaseHistory as $value)
		<tr>
			<td>${{ number_format($value->purchase_amount, 2) }}</td>
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
<div class="col-12 text-right">
	<div class="text-secondary">
		<div class="second-ajax-pag ">
			@if($purchaseHistory->count() > 0){{ $purchaseHistory->render() }}@endif   
		</div>
	</div>
</div>
