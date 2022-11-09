@extends('layouts.app')
@section('title', __('custom.Ledger'))
@section('page_title', __('custom.Ledger'))
@section('content')
    <style type="text/css">
        .stackingpool-second-ajax-report {
            float: right;
        }

        .nodes-management-second-ajax-report {
            float: right;
        }

        .referral-commission-second-ajax-report {
            float: right;
        }

        .roi-second-ajax-report {
            float: right;
        }

    </style>
    <div class="content-wrapper">
        <div class="ml-2 mb-4 d-none-desk d-md-block">
            <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
            @if (Route::currentRouteName() == 'dashboard')
                <p class="text-white">{{ str_replace('#name', auth()->user()->name, __('custom.wc_text')) }}</p>
            @endif
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-12" id="titlebar">
                <ul class="nav nav-tabs justify-content-center account-tabs border-0" id="ledgerreport">
                    <li><a class="text-warning border border-warning py-3 px-5 d-block active ledger-report"
                            data-toggle="tab" href="#home" data-type="1">{{ trans('custom.STAKING_POOLS') }}</a></li>
                    <li class="mt-3 mt-md-0"><a class="text-warning border border-warning py-3 px-5 d-block ledger-report"
                            data-toggle="tab" href="#menu1" data-type="2">{{ trans('custom.NODES_MANAGEMENT') }}</a></li>
                    <li class="mt-3 mt-md-0"><a class="text-warning border border-warning py-3 px-5 d-block ledger-report"
                            data-toggle="tab" href="#menu2" data-type="3">{{ trans('custom.REFERRAL_COMMISSION') }}</a></li>
                    <li class="mt-3 mt-md-0"><a class="text-warning border border-warning py-3 px-5 d-block ledger-report"
                            data-toggle="tab" href="#menu3" data-type="4">{{ trans('custom.ROI') }}</a></li>
                    <!--  <li class="mt-3 mt-md-0"><a class="text-warning border border-warning py-3 px-5 d-block" data-toggle="tab" href="#menu2">NFT MARKETPLACE</a></li> -->
                </ul>
            </div>





            <div class="col-12 mt-5">
                <div class="tab-content border-0">
                    <div id="home" class="tab-pane active">
                        {!! Form::open(['route' => 'reports-staking-pool-export', 'enctype' => 'multipart/form-data', 'method' => 'POST', 'id' => 'export-staking-pool']) !!}
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-md-3 col-xl-auto pr-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0">{{ trans('custom.FILTER_DATE') }}</p>
                            </div>
                            <div class="col-12 col-md-4 col-xl-auto mt-3">
                                <input name="start_date" type="text" class="form-control bg-transparent font-12 w-123"
                                    id="datepicker1" placeholder="{{ trans('custom.start_date') }}" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-1 col-xl-auto px-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0 font-12 text-center">{{ trans('custom.TO') }}</p>
                            </div>
                            <div class="col-12 col-md-4 col-xl-auto mt-3">
                                <input name="end_date" type="text" class="form-control bg-transparent font-12 w-123"
                                    id="datepicker2" placeholder="{{ trans('custom.end_date') }}" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-3 col-xl-auto pr-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0">{{ trans('custom.STAKING_POOLS') }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-xl-auto mt-3 d-flex align-items-end">
                                {!! Form::select('stackingpoolpackage', $stackingPoolPackage, old('stackingpoolpackage'), ['class' => 'form-control font-12 bg-transparent w-123', 'placeholder' => trans('custom.select_stacking_pool_package'), 'id' => 'stackingpoolpackage']) !!}
                            </div>
                            <div class="col-12 col-xl-auto ml-lg-auto mt-3 text-center">
                                <a href="#" class="btn bg-warning text-white py-3 px-4 rounded-sm"
                                    id="staking_pool_filter">{{ trans('custom.Filter') }}</a>
                                <a href="#" onclick="resetFormStakingPool()"
                                    class="btn bg-warning text-white py-3 px-4 rounded-sm"
                                    id="staking_pool_filter">{{ trans('custom.Clear') }}</a>

                                <button class="btn bg-warning text-white py-3 px-4 rounded-sm">{{ trans('custom.EXPORT') }}
                                    <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                                        class="img-fluid ml-3 d-inline align-middle" alt=""></button>
                            </div>
                        </div>
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-md-3 col-xl-auto pr-md-0 mt-3">
                            </div>
                            <div class="col-12 col-md-4 col-xl-auto mt-3">
                                <label style="display:none" id="datepicker1-error" class="error"
                                    for="datepicker1">{{ trans('custom.start_date_must_be_less_then_end_date') }}</label>
                            </div>
                            <div class="col-12 col-md-1 col-xl-auto px-md-0 mt-3">
                            </div>
                            <div class="col-12 col-md-4 col-xl-auto mt-3">
                                <label style="display:none" id="datepicker2-error" class="error"
                                    for="datepicker2">{{ trans('custom.end_date_must_be_greater_than_start_date') }}</label>

                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="table-responsive stackingpool-table-history">
                            @include('reports.partials.staking_pools_history')
                        </div>
                    </div>


                    <div id="menu1" class="tab-pane">
                        {!! Form::open(['route' => 'reports-pairing-commissions-export', 'enctype' => 'multipart/form-data', 'method' => 'POST', 'id' => 'reports-pairing-commissions-export']) !!}
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-md-2 col-xl-auto pr-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0">{{ trans('custom.FILTER_DATE') }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-xl-auto mt-3">
                                <input name="c_start_date" type="text" class="form-control bg-transparent font-12 w-123"
                                    id="datepicker3" placeholder="{{ trans('custom.start_date') }}" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-auto col-xl-auto px-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0 font-12 text-center">{{ trans('custom.TO') }}
                                </p>
                            </div>
                            <div class="col-12 col-md-3 col-xl-auto mt-3">
                                <input name="c_end_date" type="text" class="form-control bg-transparent font-12 w-123"
                                    id="datepicker4" placeholder="{{ trans('custom.end_date') }}" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-auto col-xl-auto ml-md-auto mt-3 text-center">
                                <a href="#" class="btn bg-warning text-white py-3 px-4 rounded-sm"
                                    id="node_filter">{{ trans('custom.Filter') }}</a>
                                <a href="#" onclick="resetFormNode()" class="btn bg-warning text-white py-3 px-4 rounded-sm"
                                    id="node_filter_clear">{{ trans('custom.Clear') }}</a>
                                <button class="btn bg-warning text-white py-3 px-4 rounded-sm">{{ trans('custom.EXPORT') }}
                                    <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                                        class="img-fluid ml-3 d-inline align-middle" alt=""></button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="table-responsive nodes-management-table-history">
                            @include('reports.partials.nodes_management_history')
                        </div>
                    </div>


                    <div id="menu2" class="tab-pane">
                        {!! Form::open(['route' => 'referral-commissions-export', 'enctype' => 'multipart/form-data', 'method' => 'POST', 'id' => 'referral_commission_form']) !!}
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-md-2 col-xl-auto pr-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0">{{ trans('custom.FILTER_DATE') }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-xl-auto mt-3">
                                <input name="r_start_date" type="text" class="form-control bg-transparent font-12 w-123"
                                    id="datepicker5" placeholder="{{ trans('custom.start_date') }}" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-auto col-xl-auto px-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0 font-12 text-center">{{ trans('custom.TO') }}
                                </p>
                            </div>
                            <div class="col-12 col-md-3 col-xl-auto mt-3">
                                <input name="r_end_date" type="text" class="form-control bg-transparent font-12 w-123"
                                    id="datepicker6" placeholder="{{ trans('custom.end_date') }}" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-auto col-xl-auto ml-md-auto mt-3 text-center">
                                <a href="#" class="btn bg-warning text-white py-3 px-4 rounded-sm"
                                    id="referral_filter">{{ trans('custom.Filter') }}</a>
                                <a href="#" onclick="resetFormReferral()"
                                    class="btn bg-warning text-white py-3 px-4 rounded-sm"
                                    id="referral_filter_clear">{{ trans('custom.Clear') }}</a>
                                <button class="btn bg-warning text-white py-3 px-4 rounded-sm">{{ trans('custom.EXPORT') }}
                                    <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                                        class="img-fluid ml-3 d-inline align-middle" alt=""></button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="table-responsive referral-commission-table-history">
                            @include('reports.partials.referral_commissions')
                        </div>
                    </div>



                    <div id="menu3" class="tab-pane">
                        {!! Form::open(['route' => 'roi-export', 'enctype' => 'multipart/form-data', 'method' => 'POST', 'id' => 'roi-form']) !!}
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-md-2 col-xl-auto pr-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0">{{ trans('custom.FILTER_DATE') }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-xl-auto mt-3">
                                <input name="ro_start_date" type="text" class="form-control bg-transparent font-12 w-123"
                                    id="datepicker7" placeholder="{{ trans('custom.start_date') }}" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-auto col-xl-auto px-md-0 mt-3">
                                <p class="text-white font-weight-bold mb-0 font-12 text-center">{{ trans('custom.TO') }}
                                </p>
                            </div>
                            <div class="col-12 col-md-3 col-xl-auto mt-3">
                                <input name="ro_end_date" type="text" class="form-control bg-transparent font-12 w-123"
                                    id="datepicker8" placeholder="{{ trans('custom.end_date') }}" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-auto col-xl-auto ml-md-auto mt-3 text-center">
                                <a href="#" class="btn bg-warning text-white py-3 px-4 rounded-sm"
                                    id="roi_filter">{{ trans('custom.Filter') }}</a>
                                <a href="#" onclick="resetFormROI()" class="btn bg-warning text-white py-3 px-4 rounded-sm"
                                    id="roi_filter_clear">{{ trans('custom.Clear') }}</a>
                                <button class="btn bg-warning text-white py-3 px-4 rounded-sm">{{ trans('custom.EXPORT') }}
                                    <img src="{{ asset('assets/images/assets/Staking_Pools/Group179.png') }}"
                                        class="img-fluid ml-3 d-inline align-middle" alt=""></button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <div class="table-responsive roi-table-history">
                            @include('reports.partials.roi')
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="commisionbreackdown" tabindex="-1" role="dialog" aria-labelledby="newticketsLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title inline text-white" id="exampleModalLabel">
                            {{ trans('custom.amount-breakdown') }}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                        </div>
                        <div class="cus-model-empty">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('scripts')
        <script type="text/javascript">
            $(document).on("click", "#staking_pool_filter", function(e) {
                var start_date = $('#datepicker1').val();
                var end_date = $('#datepicker2').val();
                var stackingpoolpackage = $('#stackingpoolpackage').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('stackingpoolpackage-ajax') }}",
                    cache: false,
                    data: {
                        _token: $("input[name=_token]").val(),
                        start_date: start_date,
                        end_date: end_date,
                        stackingpoolpackage: stackingpoolpackage
                    },
                    success: function(data) {
                        $(".stackingpool-table-history").html(data);
                    }
                });
            });

            function resetFormStakingPool() {
                document.getElementById("export-staking-pool").reset();
            }
            $(document).on("click", "#node_filter", function(e) {
                var start_date = $('#datepicker3').val();
                var end_date = $('#datepicker4').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('pairingcommissionajax') }}",
                    cache: false,
                    data: {
                        _token: $("input[name=_token]").val(),
                        start_date: start_date,
                        end_date: end_date,
                    },
                    success: function(data) {
                        $(".nodes-management-table-history").html(data);
                    }
                });
            });

            function resetFormNode() {
                document.getElementById("reports-pairing-commissions-export").reset();
                $.ajax({
                    type: "POST",
                    url: "{{ route('pairingcommissionajax') }}",
                    cache: false,
                    data: {
                        _token: $("input[name=_token]").val(),
                        start_date: '',
                        end_date: '',
                    },
                    success: function(data) {
                        $(".nodes-management-table-history").html(data);
                    }
                });
            }
            $(document).on("click", "#referral_filter", function(e) {
                var start_date = $('#datepicker5').val();
                var end_date = $('#datepicker6').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('referralcommissionajax') }}",
                    cache: false,
                    data: {
                        _token: $("input[name=_token]").val(),
                        start_date: start_date,
                        end_date: end_date,
                    },
                    success: function(data) {
                        $(".referral-commission-table-history").html(data);
                    }
                });
            });

            function resetFormReferral() {
                document.getElementById("referral_commission_form").reset();
                $.ajax({
                    type: "POST",
                    url: "{{ route('referralcommissionajax') }}",
                    cache: false,
                    data: {
                        _token: $("input[name=_token]").val(),
                        start_date: '',
                        end_date: '',
                    },
                    success: function(data) {
                        $(".referral-commission-table-history").html(data);
                    }
                });
            }
            $(document).on("click", "#roi_filter", function(e) {
                var start_date = $('#datepicker7').val();
                var end_date = $('#datepicker8').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('roiajax') }}",
                    cache: false,
                    data: {
                        _token: $("input[name=_token]").val(),
                        start_date: start_date,
                        end_date: end_date,
                    },
                    success: function(data) {
                        $(".roi-table-history").html(data);
                    }
                });
            });

            function resetFormROI() {
                document.getElementById("roi-form").reset();
                $.ajax({
                    type: "POST",
                    url: "{{ route('roiajax') }}",
                    cache: false,
                    data: {
                        _token: $("input[name=_token]").val(),
                        start_date: '',
                        end_date: '',
                    },
                    success: function(data) {
                        $(".roi-table-history").html(data);
                    }
                });
            }
        </script>
    @endsection
