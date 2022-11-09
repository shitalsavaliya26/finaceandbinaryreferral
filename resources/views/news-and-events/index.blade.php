@extends('layouts.app')
@section('title', __('custom.news-events'))
@section('page_title', __('custom.news-events'))
@section('content')
    <div class="content-wrapper news-main">
        <div class="ml-2 mb-4 d-none-desk d-md-block">
      <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
      @if(Route::currentRouteName() == 'dashboard')
      <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
      @endif
    </div>
        <div class="row justify-content-center mt-3">
            <div class="col-12">
                <div class="mt-2 border-0">
                    <div id="home" class="tab-pane active">
                        <div class="card">
                            <div class="card-body p-md-5">
                                <div class="row">
                                    @if ($news != null)
                                        @foreach ($news as $key => $value)
                                            <div class="col-12 col-md-6 col-xl-4 my-5">
                                                <div class="row align-item-center mt-5">
                                                    <div class="col-md-12 mb-2 ">
                                                        <a href="{{ route('news-and-events.show', $value->id) }}"><img class="card-img-top" src="{{ $value->image }}" alt="{{trans('custom.news')}}" width="100" height="200"></a>
                                                    </div>
                                                    <div class="col-md-12 mob-mt-sm">
                                                        <a class="text-dark text-decoration-none" href="{{ route('news-and-events.show', $value->id) }}"><p class=" mt-2 mb-2">
                                                            {{ date('d M Y', strtotime($value->created_at)) }}</p></a>
                                                        <h5 class="card-title fw-400 mb-2"><a class="text-dark text-decoration-none"
                                                                href="{{ route('news-and-events.show', $value->id) }}">{!! \Illuminate\Support\Str::limit($value->title,50) !!}</a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
