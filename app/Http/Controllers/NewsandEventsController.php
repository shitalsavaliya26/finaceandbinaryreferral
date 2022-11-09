<?php

namespace App\Http\Controllers;

use Auth,Session;
use App\Models\News;
use Illuminate\Http\Request;

class NewsandEventsController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $locale = app()->getLocale();
        if ($locale == 'en') {
            $locale = 'en';
        } else {
            $locale = 'cn';
        }
        $news = News::where(['status' => 'Active','lang' => $locale])->orderBy('created_at', 'desc')->get();
        return view('news-and-events.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $locale = app()->getLocale();
        if ($locale == 'en') {
            $locale = 'en';
        } else {
            $locale = 'cn';
        }
        $news = News::where('id', $id)->where(['status' => 'active','lang' => $locale])->orderBy('created_at', 'desc')->first();
        if($news==null){
            return redirect()->route('news-and-events.index');
        }
        return view('news-and-events.news-detail', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
