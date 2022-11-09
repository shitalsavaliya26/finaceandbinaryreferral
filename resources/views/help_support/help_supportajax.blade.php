<table class="table table-dark trading-table text-center table-responsive-sm table-history">
	<thead class="table-gradient">
		<tr>
			<th>{{trans('custom.subject')}}</th>
            <th>{{trans('custom.posted')}}</th>
            <th>{{trans('custom.status')}}</th>
            <th></th>
		</tr>
	</thead>
	<tbody>
		@if(count($supportTicket))
		@foreach($supportTicket as $key => $value)
		<tr>
			<td>{{$value->subject[$locale]}}</td>
			<td>{{$value->created_at}}</td>
			<td>
				@if($value->status == 0)
					<button class="btn bg-success text-white px-4 py-2 rounded-0">{{trans('custom.open')}}</button>
				@else
					<button class="btn bg-danger text-white px-4 py-2 rounded-0">{{trans('custom.close')}}</button>
				@endif
			</td>
			<td>
				<a href="{{route('supportReplay',$value->slug)}}" class="cus-text-red" title="{{trans('custom.view')}}">{{ trans('custom.view')}}</a>
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