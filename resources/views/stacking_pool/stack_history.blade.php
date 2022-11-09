<table class="table table-dark trading-table text-center">
	<thead class="table-gradient">
		<tr>
			<th>{{__('custom.date')}}</th>
			<th>{{__('custom.amount')}}</th>
			<th>{{__('custom.duration')}}</th>
		</tr>
	</thead>
	<tbody>
		@foreach($stackHistory as $stack)
		<tr>
			<td>{{$stack->created_at}}</td>
			<td>${{$stack->amount}}</td>
			<td>{{$stack->stacking_period}} Months</td>
		</tr>
		@endforeach
		<!-- <tr>
			<td>12/09/2021</td>
			<td>$20,000</td>
			<td>12 Months</td>
		</tr>
		<tr>
			<td>12/09/2021</td>
			<td>$20,000</td>
			<td>12 Months</td>
		</tr>
		<tr>
			<td>12/09/2021</td>
			<td>$20,000</td>
			<td>12 Months</td>
		</tr>
		<tr>
			<td>12/09/2021</td>
			<td>$20,000</td>
			<td>12 Months</td>
		</tr>
		<tr>
			<td>12/09/2021</td>
			<td>$20,000</td>
			<td>12 Months</td>
		</tr>
		<tr>
			<td>12/09/2021</td>
			<td>$20,000</td>
			<td>12 Months</td>
		</tr> -->
	</tbody>
</table>
<div class="col-12 text-right">
	<div class="text-secondary">
		<div class="second-ajax-pag ">
			@if($stackHistory->count() > 0){{ $stackHistory->render() }}@endif   
		</div>
	</div>
</div>