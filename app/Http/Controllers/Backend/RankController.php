<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rank;
use App\Models\Package;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $ranks = Rank::orderBy('id','asc')->paginate(10);
        return view('backend.rank.index',compact('ranks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $packages = Package::pluck('name','amount');
        view()->share('packages',$packages);
        return view('backend.rank.create');
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
        $validation = $request->validate([
            'name'=> 'required|max:255|unique:ranks,name,NULL,id,deleted_at,NULL',      
        ]);
        try {
            $ranks = new Rank();
            $ranks->name = $request->name;
            $ranks->investment = $request->investment!=""?$request->investment:0;
            $ranks->addtional_benifit = $request->addtional_benifit!=""?$request->addtional_benifit:0;
            $ranks->no_of_sponsors = $request->no_of_sponsors!=""?$request->no_of_sponsors:0;
            $ranks->personal_monthly_sale = $request->personal_monthly_sale!=""?$request->personal_monthly_sale:0;
            $ranks->personal_monthly_group_sale = $request->personal_monthly_group_sale!=""?$request->personal_monthly_group_sale:0;
            $ranks->save();
            return redirect()->route('rank_setting.index')->with(['success'=>'Rank created successfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
            
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
        $packages = Package::pluck('name','amount');
        view()->share('packages',$packages);    
        $rank = Rank::find($id);
        return view('backend.rank.edit',compact('rank'));
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
        $validation = $request->validate([
            'name'=> 'required|max:255|unique:ranks,name,' . $id . ',id,deleted_at,NULL'
        ]);
        try {
            $ranks = Rank::find($id);
            $ranks->name = $request->name;
            $ranks->investment = $request->investment!=""?$request->investment:0;
            $ranks->addtional_benifit = $request->addtional_benifit!=""?$request->addtional_benifit:0;
            $ranks->no_of_sponsors = $request->no_of_sponsors!=""?$request->no_of_sponsors:0;
            $ranks->personal_monthly_sale = $request->personal_monthly_sale!=""?$request->personal_monthly_sale:0;
            $ranks->personal_monthly_group_sale = $request->personal_monthly_group_sale!=""?$request->personal_monthly_group_sale:0;
            $ranks->save();
            return redirect()->route('rank_setting.index')->with(['success'=>'Rank updated successfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
            
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
        try {
            $rank =  Rank::find($id);
            if(!$rank){
                return redirect()->back()->with(['error'=>'Rank not Found']);
            }
            $rank->delete();

            // $user->delete();

            return redirect()->route('rank_setting.index')->with(['success'=>'Rank delete sucessfully.']);

        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
            
        }
    }
}
