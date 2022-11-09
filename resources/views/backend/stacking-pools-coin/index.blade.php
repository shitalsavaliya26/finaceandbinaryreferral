@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('css')
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>
                <div class="col-xs-12 col-md-3 p-0">[{{ $package->name }}] Package Coins</div>
                <div class="pull-right">
                    <a class="btn btn-success btn-sm"
                        href="{{ route('stacking-pools-coin.create', ['package' => $package->id]) }}" <i
                        class="fa fa-add-user"></i> Create New Coin</a>
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
                                        <th>Coin name</th>
                                        <th>Symbol</th>
                                        <th>Icon</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($coin) > 0)
                                        @if (isset($coin) && !empty($coin))
                                        @php
                                            $i = ($coin->currentpage() - 1) * $coin->perpage() + 1;
                                        @endphp
                                        @foreach ($coin as $key => $row)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    {{ $row->name }}
                                                </td>
                                                <td>
                                                    {{ $row->symbol }}
                                                </td>
                                                <td> 
                                                    @if (!empty($row->icon))
                                                    <img src="{{asset($row->icon)}}" width="auto" height="50px">
                                                    @else
                                                        
                                                    @endif
                                                </a>
                                                </td>
                                                <td>
                                                    {{ $row->price }}
                                                </td>
                                                <td>
                                                    {!! Form::open(['route' => ['stacking-pools-coin.destroy', $row->id], 'onsubmit' => "return confirmDelete(this,'Are you sure to want delete this coin ?')"]) !!}
                                                    <a class="btn btn-primary btn-xs"
                                                        href="{{ route('stacking-pools-coin.edit', [$row->id,'package' => $package->id]) }}"><i
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
                                        <td colspan="8" align="right">{!! $coin->render() !!}</td>
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
