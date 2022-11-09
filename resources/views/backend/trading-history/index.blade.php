@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>
                <div class="col-xs-12 col-md-10 p-0">[{{ $product->name ?? "" }}] Trading History</div>
                <div class="pull-right">
                    <a class="btn btn-success btn-sm"
                        href="{{ route('trading-history.create', ['product' => $product->id]) }}" 
                        <i class="fa fa-add-user"></i> Add Trading History</a>
                </div>
            </h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content bg-dark-blue">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tradinghistory) > 0)
                                        @if (isset($tradinghistory) && !empty($tradinghistory))
                                        @php
                                            $i = ($tradinghistory->currentpage() - 1) * $tradinghistory->perpage() + 1;
                                        @endphp
                                        @foreach ($tradinghistory as $key => $row)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    {{ $row->purchase_amount }}
                                                </td>
                                                <td>{{date('Y-m-d',strtotime($row->created_at))}}</td>
                                                <td>
                                                    {!! Form::open(['route' => ['trading-history.destroy', $row->id], 'onsubmit' => "return confirmDelete(this,'Are you sure to want delete this trading history ?')"]) !!}
                                                    <a class="btn btn-primary btn-xs"
                                                        href="{{ route('trading-history.edit', [$row->id,'product' => $product->id]) }}"><i
                                                            class="fa fa-edit"></i></a>
                                                    @method('delete')
                                                    <button class="btn btn-danger  btn-xs" type="submit"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="8">Oops! No Record Found.</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="8" align="right">{!! $tradinghistory->render() !!}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
