@extends('layouts.app')
@section('title', __('custom.news-events'))
@section('page_title', __('custom.news-events'))
{{-- @section('page_title', __($news->title)) --}}
@section('content')
    <div class="content-wrapper news-indi">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="tab-content border-0">
                    <div class="row mt-3 mb-5">
                        <div class="col-12">
                            <div class="withdrawal-gradient rounded text-white py-4 px-5">
                                <h2 class="mb-0 font-weight-bold">{{ $news->title }}</h2>
                            </div>
                        </div>
                    </div>
                    <div id="home" class="tab-pane active">
                        <div class="card">
                            <div class="card-body p-md-5">
                                <div class="row animated fadeInRight">
                                    <div class="col-md-12">
                                        <div class="cus-blue-bg">
                                            <div class="row">  
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="news-img">
                                                        <img src="{{$news->image}}" id="newsimg" alt="{{trans('custom.news')}}">
                                                    </div>
                                                </div>
                                                 <div class="col-lg-6 col-md-6">
                                                    <div class="ibox float-e-margins cus-box-shadow cus-blue-bg  m-t-md">      
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="ibox-content">
                                                                    <div class="news-description">
                                                                        {!! $news->details !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
