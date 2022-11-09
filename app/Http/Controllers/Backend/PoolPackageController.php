<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models as Model;
use Illuminate\Validation\Rule;

class PoolPackageController extends Controller
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
        $packages = Model\StackingPoolPackage::where('is_deleted','0')->orderBy('id','desc')->paginate($this->limit);
        return view('backend.pool-package.index',compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pool-package.create');
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
            // 'name' => 'required|string|unique:stacking_pool_packages|max:255',
            'name' => ['required','string','max:255', Rule::unique('stacking_pool_packages')->where(function ($query) {
                return $query->where('is_deleted','0');
              })
             ],
            'stacking_display_start' => 'required',            
            'stacking_display_end' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif',
            'symbol' => 'required|mimes:jpeg,jpg,png,gif'           
        ]);
        /* validation end */
        try {
            $package = new Model\StackingPoolPackage();
            $package->name = $request->name;
            $package->description = $request->description;
            $package->stacking_display_start = $request->stacking_display_start;
            $package->stacking_display_end = $request->stacking_display_end;
            $package->status = $request->status;
            if($request->image){

                $path = public_path('uploads/pool-package');
                if(!\File::isDirectory($path)) {
                    \File::makeDirectory($path, 0775, true, true);
                }
                $file_name = time().'_pool_package.'.$request->image->getClientOriginalExtension();
                // $image= $request->image->storeAs('pool-package',$file_name);
                $image= $request->image->move($path, $file_name);  
                $package->image = $file_name;
            }
            if($request->symbol){

                $path = public_path('uploads/pool-package-symbol');
                if(!\File::isDirectory($path)) {
                    \File::makeDirectory($path, 0775, true, true);
                }
                $file_name = time().'_pool_package_symbol.'.$request->symbol->getClientOriginalExtension();
                // $image= $request->image->storeAs('pool-package',$file_name);
                $image= $request->symbol->move($path, $file_name);  
                $package->symbol = $file_name;
            }
            $package->save();
            return redirect()->route('pool-packages.index')->with(["success"=>"Package created successfully"]);


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
        $package = Model\StackingPoolPackage::find($id);
        return view('backend.pool-package.edit',compact('package'));
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
            'name' => ['required','string','max:255', Rule::unique('stacking_pool_packages')->ignore($id, 'id')->where(function ($query) {
                return $query->where('is_deleted','0');
              })
             ],
            'stacking_display_start' => 'required',            
            'stacking_display_end' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif',
            'symbol' => 'mimes:jpeg,jpg,png,gif' 
        ]);
        /* validation end */
        try {
            $package = Model\StackingPoolPackage::find($id);
            $package->name = $request->name;
            $package->description = $request->description;
            $package->stacking_display_start = $request->stacking_display_start;
            $package->stacking_display_end = $request->stacking_display_end;
            $package->status = $request->status;
            if($request->image){

                $path = ('uploads/pool-package');
                if(!\File::isDirectory(public_path('uploads/pool-package'))) {
                    \File::makeDirectory($path, 0755, true);
                }
                $file_name = time().'_pool_package.'.$request->image->getClientOriginalExtension();
                // $image= $request->image->storeAs('pool-package',$file_name);
                $image= $request->image->move(public_path('uploads/pool-package'),$file_name);
                $package->image = $file_name;
            }
            if($request->symbol){

                $path = public_path('uploads/pool-package-symbol');
                if(!\File::isDirectory($path)) {
                    \File::makeDirectory($path, 0775, true, true);
                }
                $file_name = time().'_pool_package_symbol.'.$request->symbol->getClientOriginalExtension();
                // $image= $request->image->storeAs('pool-package',$file_name);
                $image= $request->symbol->move($path, $file_name);  
                $package->symbol = $file_name;
            }
            $package->save();
            return redirect()->route('pool-packages.index')->with(["success"=>"Package Update successfully"]);


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

            $package =  Model\StackingPoolPackage::find($id);
            if(!$package){
                return redirect()->back()->with(['error'=>'Package not Found']);
            }
            /*$count = Model\User::where('package_id',$id)->count();
            if( $count &&  $count > 0){
                return redirect()->back()->with(['error'=>'Some meber has been used this package. So you can not delete this package.']);
            }*/
            $package->update(['is_deleted'=>'1']);
            return redirect()->route('pool-packages.index')->with(['success'=>'Package delete sucessfully.']);

        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
            
        }
    }
}
