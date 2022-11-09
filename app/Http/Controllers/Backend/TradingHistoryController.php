<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NftPurchaseLog;
use App\Models\NftProduct;

class TradingHistoryController extends Controller
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
        //
        $product = NftProduct::find($request->get('product'));
        if (!$product) {
            return redirect()
                ->back()
                ->with(['error' => 'Product not Found']);
        }
        return view('backend.trading-history.create', compact('product'));
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
            'purchase_amount' => 'required', 
            'date' => 'required',        
        ]);
        
         /* validation end */
         try {
            NftPurchaseLog::insert(
                ['purchase_user_type' => 'user', 'product_id' => $request->productid,'purchase_amount' => $request->purchase_amount,'created_at' => $request->date,'updated_at' => $request->date]
            );        
            return redirect()->route('trading-history.show',[$request->productid])->with(["success"=>"Trading history added successfully"]);
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
        $product = NftProduct::find($id);
        $tradinghistory = NftPurchaseLog::where('product_id', $id)->orderBy('id','desc')->paginate($this->limit);

        if (!$product) {
            return redirect()
                ->back()
                ->with(['error' => 'Product not Found']);
        }
        return view('backend.trading-history.index', compact('tradinghistory','product'));
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
        //
        $product = NftProduct::find($request->get('product'));

        if (!$product) {
            return redirect()
                ->back()
                ->with(['error' => 'Product not Found']);
        }
        $nftpurchaselog = NftPurchaseLog::find($id);
        return view('backend.trading-history.edit',compact('nftpurchaselog','product'));
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
            'purchase_amount' => 'required', 
            'date' => 'required',        
        ]);
        
         /* validation end */
         try {
            NftPurchaseLog::where([
                'id' => $id
            ])->update(
                ['purchase_amount' => $request->purchase_amount,'created_at' => $request->date,'updated_at' => $request->date]
            );        
            return redirect()->route('trading-history.show',[$request->productid])->with(["success"=>"Trading history update successfully"]);
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
            $nftpurchaselog =  NftPurchaseLog::find($id);
            if(!$nftpurchaselog){
                return redirect()->back()->with(['error'=>'Trading history not Found']);
            }
            $nftpurchaselog->delete();
            return redirect()->back()->with(['success'=>'Trading history delete sucessfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }
}
