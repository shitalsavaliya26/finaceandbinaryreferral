<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function __construct(Request $request){
        $this->limit = $request->limit?$request->limit:10; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $news = new News();

        $news = $news->orderBy('id','desc')->paginate($this->limit);
        return view('backend.news.index',compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.news.create');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required',
            'details' => 'required|max:2500',
            'url' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif'
        ]);
        try {
            $news = new News();
            $news->title = $request->title;
            $news->lang = $request->language;
            $news->url = $request->url;
            $news->details = $request->details;
            $news->slug = '';
            if($request->image){

                $path = ('uploads/news');
                if(!\File::isDirectory(public_path('uploads/news'))) {
                    \File::makeDirectory(public_path('uploads/news'),  $mode = 0755, $recursive = true);
                }
                $file_name = time().'_news.'.$request->image->getClientOriginalExtension();
                // $image= $request->image->storeAs('news',$file_name); 
                $image= $request->image->move(public_path('uploads/news'),$file_name); 
                $news->image = $file_name;
            }
            $news->status = $request->status;
            $news->save();
            return redirect()->route('news.index')->with('success','News create successfully');

        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
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
        $news = News::find($id);
        if(!$news){
            return redirect()->back()->with('error','No recored found.');
        }
        return view('backend.news.edit',compact('news'));
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
        $news = News::find($id);
        if(!$news){
            return redirect()->back()->with('error','No recored found.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required',
            'details' => 'required|max:2500',
            'url' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif'
        ]);
        try {

            if($request->image){

                $path = ('news');
                if(!\File::isDirectory(public_path('uploads/news'))) {
                    \File::makeDirectory(public_path('uploads/news'),  $mode = 0755, $recursive = true);
                }
                $file_name = time().'_news.'.$request->image->getClientOriginalExtension();
                // $image= $request->image->storeAs('news',$file_name);  
                $image= $request->image->move(public_path('uploads/news'),$file_name); 
                $news->image = $file_name;
            }
            $news->title = $request->title;
            $news->lang = $request->language;
            $news->url = $request->url;
            $news->details = $request->details;
            $news->status = $request->status;
            $news->slug = '';
            $news->save();
            return redirect()->route('news.index')->with('success','News Update successfully');
            
        } catch (Exception $e) {
            
        }
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
        $news = News::find($id);
        if(!$news){
            return redirect()->back()->with('error','No recored found.');
        }
        $news->delete();
        return redirect()->route('news.index')->with('success','News delete successfully');
    }
}
