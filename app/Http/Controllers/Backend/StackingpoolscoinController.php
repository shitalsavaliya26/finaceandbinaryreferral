<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\StackingPoolCoin;
use App\Models\StackingPoolPackage;
use App\Http\Controllers\Controller;

class StackingpoolscoinController extends Controller
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $package = StackingPoolPackage::find($request->get('package'));

        if (!$package) {
            return redirect()
                ->back()
                ->with(['error' => 'Package not Found']);
        }
        return view('backend.stacking-pools-coin.create', compact('package'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $packageid = $request->packageid;
        /* validation start */
        $validatedData = $request->validate([
            // 'name' => 'required|string|max:255',
            'name' => [
                'required',
                Rule::unique('stacking_pools_coins')->where(function ($query) use($packageid) {
                    return $query->where('stacking_pool_package_id', $packageid);
                }),
            ],
            'symbol' => 'required|string|max:30',
            'image' => 'required|mimes:jpeg,jpg,png,gif',
            'price' => 'required', 
            'chain' => 'required', 
            // 'address' => 'required',            
        ],[
            'name.unique' => 'Coin already exists!',
        ]);
        
         /* validation end */
         try {
            $package = new StackingPoolCoin();
            $package->stacking_pool_package_id = $request->packageid;
            $package->name = $request->name;
            $package->price = $request->price;
            $package->symbol = $request->symbol;
            $package->chain = $request->chain;
            // $package->address = $request->address;
            if($request->image){

                $path = public_path('uploads/package_coin');
                if(!\File::isDirectory($path)) {
                    \File::makeDirectory($path, 0775, true, true);
                }
                $file_name = time().'coin.'.$request->image->getClientOriginalExtension();
                // $image= $request->image->storeAs('pool-package',$file_name);
                $image= $request->image->move($path, $file_name);  
                $package->icon = $file_name;
            }
            $package->save();
            return redirect()->route('stacking-pools-coin.show',[$request->packageid])->with(["success"=>"Coin added successfully"]);
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
        $package = StackingPoolPackage::find($id);
        $coin = StackingPoolCoin::where('stacking_pool_package_id', $id)->orderBy('id','desc')->paginate($this->limit);

        if (!$package) {
            return redirect()
                ->back()
                ->with(['error' => 'Package not Found']);
        }
        return view('backend.stacking-pools-coin.index', compact('package','coin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        //
        $package = StackingPoolPackage::find($request->get('package'));

        if (!$package) {
            return redirect()
                ->back()
                ->with(['error' => 'Package not Found']);
        }
        $coin = StackingPoolCoin::find($id);
        return view('backend.stacking-pools-coin.edit',compact('package','coin'));
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
        $packageid = $request->packageid;
         /* validation start */
         $validatedData = $request->validate([
            // 'name' => 'required|string|max:255|unique:packages,name,'.$id,
            'name' => [
                'required',
                Rule::unique('stacking_pools_coins')->ignore($id, 'id')->where(function ($query) use($packageid) {
                    return $query->where('stacking_pool_package_id', $packageid);
                }),
            ],
            'symbol' => 'required|string|max:30',
            'image' => 'mimes:jpeg,jpg,png,gif',
            'price' => 'required',
            'chain' => 'required', 
            // 'address' => 'required',
         ],[
            'name.unique' => 'Coin already exists!',
        ]);
        /* validation end */
        try {
            $package = StackingPoolCoin::find($id);
            $package->stacking_pool_package_id = $request->packageid;
            $package->name = $request->name;
            $package->price = $request->price;
            $package->symbol = $request->symbol;
            $package->chain = $request->chain;
            // $package->address = $request->address;
            if($request->image){

                $path = public_path('uploads/package_coin');
                if(!\File::isDirectory($path)) {
                    \File::makeDirectory($path, 0775, true, true);
                }
                $file_name = time().'coin.'.$request->image->getClientOriginalExtension();
                // $image= $request->image->storeAs('pool-package',$file_name);
                $image= $request->image->move($path, $file_name);  
                $package->icon = $file_name;
            }
            $package->save();
            return redirect()->route('stacking-pools-coin.show',[$request->packageid])->with(["success"=>"Coin Update successfully"]);
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
        //
        try {

            $coin =  StackingPoolCoin::find($id);
            if(!$coin){
                return redirect()->back()->with(['error'=>'Package not Found']);
            }
            $coin->delete();
            return redirect()->back()->with(['success'=>'Coin delete sucessfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
            
        }
    }
}
