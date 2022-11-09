        <div class="table-responsive model-table-history">
            {{-- <table class="table table-striped cus-dat-model" data-model="{{ $model }}"
                data-id="{{ $uid }}"> --}}
            <table class="table table-dark trading-table text-center table-responsive-sm cus-dat-model" data-model="{{ $model }}"
            data-id="{{ $uid }}">
                <thead class="table-gradient">
                    <tr>
                      <th>{{trans('custom.AMOUNT')}}
                      </th>
                      <th>{{trans('custom.PERCENTAGE')}}</th>
                      <th>{{trans('custom.FROM_USER')}}</th>
                      <th>{{trans('custom.DATE')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($stackingpool))
                        @foreach ($stackingpool as $key => $value)
                            <tr>
                                <td>{{ $value->amount }}</td>
                                <td>{{ $value->percent }}</td>
                                <td>{{ $value->from_user_detail->username }}</td>
                                <td>{{ date('d/m/Y', strtotime($value->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr >
                        <td colspan="10" class="no-records text-center">{{trans('custom.no_data_found')}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{-- <div class="model-ajax-pag">
                @if (isset($stackingpool)){{ $stackingpool->render() }}@endif
            </div> --}}
        </div>
        <div class="row align-items-center mt-5">
            <div class="col-12 text-right">
              <div class="text-secondary">
                <div class="model-ajax-pag">
                    @if (isset($stackingpool)){{ $stackingpool->render() }}@endif
                </div>
              </div>
            </div>
        </div>
