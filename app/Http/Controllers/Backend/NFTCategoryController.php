<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models as Model;
use Illuminate\Validation\Rule;

class NFTCategoryController extends Controller
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
        $categories = Model\NftCategory::where('is_deleted','0')->where('status','active')->orderBy('id','desc')->paginate($this->limit);
        return view('backend.nft-category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.nft-category.create');
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
            // 'name' => 'required|string|max:255',
            'name' => ['required','string','max:255', Rule::unique('nft_categories')->where(function ($query) {
                return $query->where('is_deleted','0');
              })
             ],
            'image' => 'required|mimes:jpeg,jpg,png,gif',
            'order_id' => ["nullable",Rule::unique('nft_categories')->where(function ($query) {
                return $query->where('is_deleted','0');
              })
             ],        
        ],[
            'name.unique' => 'Category name already exists!',
            'order_id.unique' => 'Arrangement Sequence Number already exists!',
        ]);
        /* validation end */
        try {
            $category = new Model\NftCategory();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->status = $request->status;
            $category->order_id = $request->order_id;
            if($request->image){

                $path = public_path('uploads/nft-category');
                if(!\File::isDirectory($path)) {
                    \File::makeDirectory($path, 0775, true, true);
                }
                $file_name = time().'_nft_category.'.$request->image->getClientOriginalExtension();
                $image= $request->image->move($path, $file_name);  
                $category->image = $file_name;
            }
            $category->save();
            return redirect()->route('nft-category.index')->with(["success"=>"Category created successfully"]);


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
        $category = Model\NftCategory::find($id);
        return view('backend.nft-category.edit',compact('category'));
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
            // 'name' => 'required|string|max:255',
            'name' => ['required','string','max:255', Rule::unique('nft_categories')->ignore($id, 'id')->where(function ($query) {
                return $query->where('is_deleted','0');
              })
             ],
            'image' => 'mimes:jpeg,jpg,png,gif',
            'order_id' => ["nullable",Rule::unique('nft_categories')->ignore($id, 'id')->where(function ($query) {
                return $query->where('is_deleted','0');
              })
             ]
        ],[
            'name.unique' => 'Category name already exists!',
            'order_id.unique' => 'Arrangement Sequence Number already exists!',
        ]);
        /* validation end */
        try {
            $category = Model\NftCategory::find($id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->status = $request->status;
            $category->order_id = $request->order_id;
            if($request->image){

                $path = ('uploads/nft-category');
                if(!\File::isDirectory(public_path('uploads/nft-category'))) {
                    \File::makeDirectory($path, 0755, true);
                }
                $file_name = time().'_nft_category.'.$request->image->getClientOriginalExtension();
                $image= $request->image->move(public_path('uploads/nft-category'),$file_name);
                $category->image = $file_name;
            }
            $category->save();
            return redirect()->route('nft-category.index')->with(["success"=>"Category Update successfully"]);


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

            $category =  Model\NftCategory::find($id);
            if(!$category){
                return redirect()->back()->with(['error'=>'Category not Found']);
            }
            $category->update(['is_deleted'=>'1']);
            return redirect()->route('nft-category.index')->with(['success'=>'Category delete sucessfully.']);

        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
            
        }
    }
}
