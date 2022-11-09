@extends('layouts.app')
@section('title', __('custom.help_and_faq'))
@section('page_title', __('custom.help_and_faq'))
@section('content')
    <div class="content-wrapper">
        <div class="ml-2 mb-4 d-none-desk d-md-block">
      <h2 class="text-warning font-weight-bold">@yield('page_title','Dashboard')</h2>
      @if(Route::currentRouteName() == 'dashboard')
      <p class="text-white">{{str_replace('#name',auth()->user()->name,__('custom.wc_text'))}}</p>
      @endif
    </div>
        <div class="row justify-content-center">
            <div class="col-12 mt-2">
                <div class="mt-2 border-0">
                    <div id="home" class="tab-pane active">
                        <div class="card">
                            <div class="card-body p-md-5">
                                {{-- <div class="row"> --}}
                                    {!! trans('custom.helpone') !!}
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
