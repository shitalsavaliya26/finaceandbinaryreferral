<?php

namespace App\Http\Controllers\Backend;

use App\Models as Model;
use App\Models\NftProduct;
use App\Models\NftCategory;
use Illuminate\Http\Request;
use App\Models\NftPurchaseHistory;
use App\Http\Controllers\Controller;

class NFTProductController extends Controller
{
    public function __construct(Request $request){
        $this->limit = $request->limit?$request->limit:10;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = NftProduct::with(['nftcategory','nftpurchasehistory'=> function ($query) {
            $query->with('user_detail');
        }]);

      
        if($request->product_status && $request->product_status != ""){
            $products = $products->where('product_status',$request->product_status);
        }

        if($request->category && $request->category != ""){
            $products = $products->where('category_id',$request->category);
        }

        if($request->keyword && $request->keyword != ""){
            $products = $products->where('name', 'like', '%' . $request->keyword . '%');
        }

        if($request->owner && $request->owner != ""){

            if($request->owner == "admin"){
                $products = $products->doesntHave("nftpurchasehistory"); 
            }else{
                $products = $products->whereHas('nftpurchasehistory',function($query) use ($request){
                    $query->where('user_id',$request->owner);
                });
            }
        }

        $data = $request->all();
        $products = $products->where('is_deleted','0')->orderBy('id','desc')->paginate($this->limit)->appends($request->all());
     
        return view('backend.nft-product.index', compact('products','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Model\NftCategory::where(['is_deleted' => '0', 'status' => 'active'])->pluck('name', 'id');
        return view('backend.nft-product.create', compact('categories'));
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
            'name' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif'          
        ]);
        /* validation end */
        try {
            $primary_image_name = '';
            if($request->image){

                $path = public_path('uploads/nft-product');
                if(!\File::isDirectory($path)) {
                    \File::makeDirectory($path, 0775, true, true);
                }
                $primary_image_name = time().'_nft_product.'.$request->image->getClientOriginalExtension();
                $file= $request->image->move($path, $primary_image_name);  
                // $product->image = $primary_image_name;
            }
            $product = new Model\NftProduct();
            $product->category_id = $request->category;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->status = $request->status;
            $product->product_status = $request->product_status;
            $product->image = $primary_image_name;
            $product->save();

            if(!empty($request->form)){
                $data = $request->all();
                $image = $data['form']['file'];
                $totalImages = count($data['form']['file']);
                $validImageCount = 0;
                if ($image) {
                    $validExtension = ['jpg', 'jpeg', 'png'];
                    foreach ($image as $file) {
                        $image_parts = explode(";base64,", $file);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        if (key_exists(1, $image_type_aux)) {
                            if (in_array($image_type_aux[1], $validExtension)) {
                                $validImageCount++;
                            }
                        }
                    }
                }

                if ($totalImages == $validImageCount) {
                    $image = $data['form']['file'];
                    if ($image) {
                        foreach ($image as $file) {
                            $image_parts = explode(";base64,", $file);
                            $image_type_aux = explode("image/", $image_parts[0]);
                            $image_type = key_exists(1, $image_type_aux) ? $image_type_aux[1] : time();
                            $image_base64 = base64_decode($image_parts[1]);
                            // $renamed = time().'_nft_product' . '.' . $image_type;
                            $renamed = time() . rand() . '_nft_product.' . $image_type;
                            file_put_contents(public_path('uploads/nft-product/') . $renamed, $image_base64);
    
                            $productImage = new Model\NftProductImage;
                            $productImage->product_id = $product->id;
                            $productImage->image = $renamed;
                            $productImage->save();
                            $request->session()->pull('uploadImage', $image);
                        }
                    }
                }else{
                    return redirect()->route('nft-product.index')->with('error', 'Please upload only jpg, jpeg and png files');
                }
            }
            return redirect()->route('nft-product.index')->with('success','Product create successfully');

            // return redirect()->route('nft-product.index')->with(["success"=>"Product created successfully"]);

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
        // $product = NftPurchaseHistory::where(['product_id' => $id])->whereIn('status',[1,2])->count();
        $product = Model\NftProduct::with('images')->find($id);

        if($product->product_status == 'Withdrawn'){
           return redirect()->route('nft-product.index')->with('error', 'You have not access to edit this product.');
        }
        // if($product > 0){
        //     return redirect()->route('nft-product.index')->with('error', 'Product is purchased you can not edit.');
        // }else{
            $categories = Model\NftCategory::where(['is_deleted' => '0', 'status' => 'active'])->pluck('name', 'id');
            return view('backend.nft-product.edit',compact('product', 'categories'));
        // }
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
            'name' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif'
        ]);
        /* validation end */
        try {
            $data = $request->all();
            $product = Model\NftProduct::find($id);
            if($product->product_status == 'Withdrawn'){
                return redirect()->route('nft-product.index')->with(["success"=>"You have not access to update this product"]);
            }
            if (isset($data['remove_img']) && $data['remove_img'] != '') 
            {
                $removeImage = explode(",", $data['remove_img']);
                foreach ($removeImage as $image) 
                {
                    Model\NftProductImage::find($image)->delete();
                }
            }
            $product->category_id = $request->category;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->status = $request->status;
            $product->product_status = $request->product_status;
            if($request->image){

                $path = ('uploads/nft-product');
                if(!\File::isDirectory(public_path('uploads/nft-product'))) {
                    \File::makeDirectory($path, 0755, true);
                }
                $file_name = time().'_nft_product.'.$request->image->getClientOriginalExtension();
                $image= $request->image->move(public_path('uploads/nft-product'),$file_name);
                $product->image = $file_name;
            }
            $product->save();
            
            if (isset($data['form'])) 
            {
                $image = $data['form']['file'];
                $totalImages = count($data['form']['file']);
                $validImageCount = 0;
                if ($image) 
                {
                    $validExtension = ['jpg', 'jpeg', 'png'];
                    foreach ($image as $file) {
                        $image_parts = explode(";base64,", $file);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        if (key_exists(1, $image_type_aux)) {
                            if (in_array($image_type_aux[1], $validExtension)) {
                                $validImageCount++;
                            }
                        }
                    }
                }
                if ($totalImages == $validImageCount) 
                {
                    $images = $request->session()->get('uploadImage');
                    if ($request->session()->get('uploadImage') != '') 
                    {
                        foreach ($images as $image) 
                        {
                            $productImage = new Model\NftProductImage;
                            $productImage->product_id = $product->id;
                            $productImage->image = $image;
                            $productImage->save();
                            $request->session()->pull('uploadImage', $image);
                        }
                    }
                    if (isset($data['form'])) 
                    {
                        $image = $data['form']['file'];

                        if ($image) 
                        {
                            foreach ($image as $file) 
                            {
                                $image_parts = explode(";base64,", $file);
                                $image_type_aux = explode("image/", $image_parts[0]);
                                $image_type = $image_type_aux[1];
                                $image_base64 = base64_decode($image_parts[1]);
                                // $renamed = time().'_nft_product' . '.' . $image_type;
                                $renamed = time() . rand() . '_nft_product.' . $image_type;
                                file_put_contents(public_path('uploads/nft-product/') . $renamed, $image_base64);

                                $productImage = new Model\NftProductImage;
                                $productImage->product_id = $product->id;
                                $productImage->image = $renamed;
                                $productImage->save();
                                $request->session()->pull('uploadImage', $image);
                            }
                        }
                    }
                }
                else
                {
                    return redirect()->route('nft-product.create')->with('error', 'Please upload only jpg, jpeg and png files');
                }
            }
            return redirect()->route('nft-product.index')->with(["success"=>"Product Update successfully"]);


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
            $product = NftPurchaseHistory::where(['product_id' => $id])->whereIn('status',[1,2])->count();
            if($product > 0){
                return redirect()->route('nft-product.index')->with('error', 'Product is purchased you can not edit.');
            }else{
                $product =  Model\NftProduct::find($id);
                if(!$product){
                    return redirect()->back()->with(['error'=>'Product not Found']);
                }
                $product->update(['is_deleted'=>'1']);
                return redirect()->route('nft-product.index')->with(['success'=>'Product delete sucessfully.']);
            }   
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
            
        }
    }
}
