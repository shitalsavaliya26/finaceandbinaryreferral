<div class="row mt-4">
    <div class="col-12">
        <table class="table table-dark trading-table text-center table-responsive-sm datas">
            <thead class="table-gradient">
                <tr>
                    <th>{{trans('custom.AMOUNT')}}</th>
                    <th>{{ trans('custom.STAKING_POOLS') }}
                    </th>
                    <th>{{ trans('custom.DURATION') }}
                    </th>
                    <th>{{ trans('custom.DATE') }}
                    </th>
                    <th>{{ trans('custom.ACTION') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (count($stackingpool))
                    @foreach ($stackingpool as $key => $value)
                        <tr>
                            <td>{{ number_format($value->amount, 2) }}</td>
                            <td>{{ @$value->staking_pool_package->name ? $value->staking_pool_package->name : '-' }}
                            </td>
                            <td>{{ $value->stacking_period }}</td>
                            <td>{{ date('d/m/Y', strtotime($value->created_at)) }}</td>
                            <td><a href="javascript:;" data-id="{{ $value->id }}" data-toggle="modal"
                                    data-target="#commisionbreackdown" data-model="pipscommision" class="cus-model-table"
                                    style="color: #007bff;">{{ trans('custom.view') }}</a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" class="no-records text-center">{{ trans('custom.no_data_found') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="row align-items-center mt-5">
    <div class="col-12 text-right">
        <div class="text-secondary">
            <div class="stackingpool-second-ajax-report">
                @if ($stackingpool->count() > 0){{ $stackingpool->render() }}@endif
            </div>
        </div>
    </div>
</div>
