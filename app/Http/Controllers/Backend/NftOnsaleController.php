<?php

namespace App\Http\Controllers\Backend;


use Carbon\Carbon;
use App\Models\User;
use App\Models\NftProduct;
use Illuminate\Http\Request;
use App\Models\NftPurchaseHistory;
use App\Http\Controllers\Controller;
use App\Models\NftSellHistory;

class NftOnsaleController extends Controller
{
    public function __construct(Request $request){
        $this->limit = $request->limit?$request->limit:50;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $data = $request->all();
            $nft_onsale_history = NftSellHistory::with([
                'user_detail' => function ($query) {
                    $query->withTrashed();
                },
                'nftproduct',
                'nftpurchasehistory'
            ]);

           
            /* Search Functions start*/
            if($request->request_date && $request->request_date != ""){
                $date = date('Y-m-d',strtotime($request->request_date));
                $nft_onsale_history = $nft_onsale_history->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") = "'.$date.'"');
            }

            if($request->username && $request->username != ""){
                $nft_onsale_history = $nft_onsale_history->whereHas('user_detail',function($query) use ($request){
                    $query->where('username',$request->username);
                });
            }

            $nft_onsale_history = $nft_onsale_history->whereIn('status',[2]);

            $data['total_uploads'] = $nft_onsale_history->count();
            $data['total_sales'] = $nft_onsale_history->sum('sale_amount');

            /* Search Functions end*/
            $nft_onsale_history = $nft_onsale_history->orderBy('id','desc')->paginate($this->limit)->appends($request->all());
            return view('backend.nft_on_sale_request.index',compact('nft_onsale_history','data'));
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
        if ($request->ajax() || $request->status != '') {
            try {
                $change_status = NftSellHistory::find($id);
                if ($change_status == null && $change_status == "") {
                    return response()->json(['status' => 'fail', 'message' => trans('custom.no_data_found')]);
                }
                if($request->status == 5){
                    $change_status->status = ($request->status != "") ? $request->status : "0";
                    $change_status->approve_for_processing_date = Carbon::now();
                }else{
                    $change_status->status = ($request->status != "") ? $request->status : "0";
                    $nfttype = NftPurchaseHistory::find($change_status->nft_purchase_history_id);
                    $nfttype->type = 0;
                    $nfttype->save();
                }
                $change_status->save();
                return response()->json(['status' => 'success', 'message' => "NFT On Sell Request update successfully..", 'data' => $change_status]);
            } catch (Exception $e) {
                return response()->json(['status' => 'fail', 'message' => "Something went wrong......"]);
            }
        }
        return response()->json($id);
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
