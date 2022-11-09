<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $settings  = Setting::all();
        $setting = [];
        foreach ($settings as $key => $value) {
            $setting[$value['key']]=$value['value'];
        }
        $dateformat = array(
            '' => '--Select Date Format--',
            'd/M/y' => 'd/M/y',
            'd.M.y' => 'd.M.y',
            'd-m-Y' => 'd-m-Y',
            'M/d/y' => 'M/d/y',
            'M.d.y' => 'M.d.y',
            'y/M/d' => 'y/M/d',
            'y.M.d' => 'y.M.d',
            'y-M-d' => 'y-M-d',
            'Y-m-d' => 'Y-m-d',
            'F j, Y' => 'F j, Y'
        );
        // dd($setting);
        return view('backend.setting.index',compact('setting','dateformat'));
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
        $data = $request->except(['_token','type']);
        $message = "";
        if($request->type == 'general_setting'){
            foreach ($data as $key => $value) {
                if($key!=""){
                    if($key!=""){
                        $setting = Setting::firstOrCreate(['key'=>$key]);
                        $setting->value = $value;
                        $setting->save();
                    }       
                }
            }
            $message = "General setting update successfully.";
        }
        return redirect()->back()->with('success',$message);
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
