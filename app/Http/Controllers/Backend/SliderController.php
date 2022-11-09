<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
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
        $sliders = new Slider();
        $sliders = $sliders->orderBy('id','desc')->paginate($this->limit);
        return view('backend.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            // 'daterange' => 'required',
            'mobile_image' => 'required|mimes:jpeg,jpg,png,gif',
            'url' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif'
        ]);
        try {

            // list($start, $end) = explode(" - ", $request->daterange);
            $slider = new Slider();
            $slider->title = $request->title;
            $slider->url = $request->url;
            // $slider->startdate = date('Y-m-d',strtotime($start));
            // $slider->enddate = date('Y-m-d',strtotime($end));
            $slider->status = 'active';


            if($request->image){
                $path = ('uploads/slider');
                if(!\File::isDirectory(public_path('uploads/slider'))) {
                    \File::makeDirectory(public_path('uploads/slider'),  $mode = 0755, $recursive = true);
                }
                $file_name = time().'_slider.'.$request->image->getClientOriginalExtension();
                // $image= $request->image->storeAs('slider',$file_name);  
                $image= $request->image->move(public_path('uploads/slider'),$file_name);
                $slider->image = $file_name;
            }

             if($request->mobile_image){
                $path = ('uploads/slider');
                if(!\File::isDirectory(public_path('uploads/slider'))) {
                    \File::makeDirectory(public_path('uploads/slider'),  $mode = 0755, $recursive = true);
                }
                $file_name = time().'_slidermb.'.$request->mobile_image->getClientOriginalExtension();
                // $image= $request->mobile_image->storeAs('slider',$file_name); 
                $image= $request->mobile_image->move(public_path('uploads/slider'),$file_name); 
                $slider->mobile_image = $file_name;
            }
            $slider->save();
            return redirect()->route('slider.index')->with('success','Slider create successfully');

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
        $slider = Slider::find($id);
        if(!$slider){
            return redirect()->back()->with('error','No recored found.');
        }
        return view('backend.slider.edit',compact('slider'));
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
        $slider = Slider::find($id);
        if(!$slider){
            return redirect()->back()->with('error','No recored found.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            // 'daterange' => 'required',
            'mobile_image' => 'mimes:jpeg,jpg,png,gif',
            'url' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif'
        ]);
        try {

            // list($start, $end) = explode(" - ", $request->daterange);
            $slider->title = $request->title;
            // $slider->description = $request->description;
            // $slider->startdate = date('Y-m-d',strtotime($start));
            // $slider->enddate = date('Y-m-d',strtotime($end));
            $slider->url = $request->url;
            $slider->status = 'active';



            if($request->image){

                $path = ('uploads/slider');
                if(!\File::isDirectory(public_path('uploads/slider'))) {
                    \File::makeDirectory(public_path('uploads/slider'),  $mode = 0755, $recursive = true);
                }
                $file_name = time().'_slider.'.$request->image->getClientOriginalExtension();
                // $image= $request->image->storeAs('slider',$file_name); 
                $image= $request->image->move(public_path('uploads/slider'),$file_name);  
                // echo public_path($path).'/'.$slider->image;die();
                // unlink(public_path($path).'/'.$slider->image);

                $slider->image = $file_name;
            }
             if($request->mobile_image){

                $path = ('uploads/slider');
                if(!\File::isDirectory(public_path('uploads/slider'))) {
                    \File::makeDirectory(public_path('uploads/slider'),  $mode = 0755, $recursive = true);
                }
                $file_name = time().'_slidermb.'.$request->mobile_image->getClientOriginalExtension();
                // $image= $request->mobile_image->storeAs('slider',$file_name);
                $image= $request->mobile_image->move(public_path('uploads/slider'),$file_name); 
                // unlink(public_path($path).'/'.$slider->mobile_image);
                $slider->mobile_image = $file_name;
            }
            $slider->save();
            return redirect()->route('slider.index')->with('success','Slider updated successfully');

        }catch(Exception $e){

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
        $slider = Slider::find($id);
        if(!$slider){
            return redirect()->back()->with('error','No recored found.');
        }
        $slider->delete();
        return redirect()->route('slider.index')->with('success','Slider delete successfully');
    }
}
