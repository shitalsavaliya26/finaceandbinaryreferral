<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models as Model;
use Illuminate\Validation\Rule;

class PackageController extends Controller
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
        $packages = Model\Package::where('is_deleted','0')->orderBy('id','desc')->paginate($this->limit);
        return view('backend.package.index',compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* validation start */
        $validatedData = $request->validate([
            // 'name' => 'required|string|max:255|unique:packages',
            'name' => ['required','string','max:255', Rule::unique('packages')->where(function ($query) {
                return $query->where('is_deleted','0');
              })
             ],
            'amount' => 'required',            
            'stacking_actual12_start' => 'required',            
            'stacking_actual12_end' => 'required',            
            'stacking_actual24_start' => 'required',            
            'stacking_actual24_end' => 'required',            
            'direct_refferal' => 'required',            
            'network_pairing' => 'required',            
            'daily_limit' => 'required',          
        ]);
        /* validation end */
        try {
            $package = new Model\Package();
            $package->name = $request->name;
            $package->amount = $request->amount;
            $package->stacking_actual12_start = $request->stacking_actual12_start;
            $package->stacking_actual12_end = $request->stacking_actual12_end;
            $package->stacking_actual24_start = $request->stacking_actual24_start;
            $package->stacking_actual24_end = $request->stacking_actual24_end;
            $package->direct_refferal = $request->direct_refferal;
            $package->network_pairing = $request->network_pairing;
            $package->daily_limit = $request->daily_limit;
            $package->status = $request->status;
            $package->save();
            return redirect()->route('packages.index')->with(["success"=>"Package created successfully"]);


        } catch (Exception $e) {
            return redirect()->back()->with(["error"=>$e->getMessage()]);
            
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
        $package = Model\Package::find($id);
        return view('backend.package.edit',compact('package'));
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
        /* validation start */
        $validatedData = $request->validate([
            // 'name' => 'required|string|max:255|unique:packages,name,'.$id,
            'name' => ['required','string','max:255', Rule::unique('packages')->ignore($id, 'id')->where(function ($query) {
                return $query->where('is_deleted','0');
              })
             ],
            'amount' => 'required',
            'stacking_actual12_start' => 'required',            
            'stacking_actual12_end' => 'required',            
            'stacking_actual24_start' => 'required',            
            'stacking_actual24_end' => 'required',            
            'direct_refferal' => 'required',            
            'network_pairing' => 'required',            
            'daily_limit' => 'required',            
        ]);
        /* validation end */
        try {
            $package = Model\Package::find($id);
            $package->name = $request->name;
            $package->amount = $request->amount;
            $package->stacking_actual12_start = $request->stacking_actual12_start;
            $package->stacking_actual12_end = $request->stacking_actual12_end;
            $package->stacking_actual24_start = $request->stacking_actual24_start;
            $package->stacking_actual24_end = $request->stacking_actual24_end;
            $package->direct_refferal = $request->direct_refferal;
            $package->network_pairing = $request->network_pairing;
            $package->daily_limit = $request->daily_limit;
            $package->status = $request->status;
            $package->save();
            return redirect()->route('packages.index')->with(["success"=>"Package Update successfully"]);


        } catch (Exception $e) {
            return redirect()->back()->with(["error"=>$e->getMessage()]);
            
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
        try {

            $package =  Model\Package::find($id);
            if(!$package){
                return redirect()->back()->with(['error'=>'Package not Found']);
            }
            $count = Model\User::where('package_id',$id)->count();
            if( $count &&  $count > 0){
                return redirect()->back()->with(['error'=>'Some meber has been used this package. So you can not delete this package.']);
            }
            $package->update(['is_deleted'=>'1']);
            return redirect()->route('packages.index')->with(['success'=>'Package delete sucessfully.']);

        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
            
        }
    }
}
