<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\NftProduct;
use Illuminate\Http\Request;
use App\Models\NftPurchaseHistory;
use App\Http\Controllers\Controller;
use App\Models\NftSellHistory;

class NftpurchaserequestController extends Controller
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
        //
        try{
            $data = $request->all();
            $nft_purchase_history = NftSellHistory::with([
                'user_detail' => function ($query) {
                    $query->withTrashed();
                },
                'nftproduct',
                'nftpurchasehistory'
            ]);

            if($request->ajax()){
                if($nft_purchase_history == null && $nft_purchase_history == ""){
                    return response()->json(['status'=>'fail','message'=>"{{trans('custom.no_data_found')}}...."]);
                }
                $nft_purchase_history->status = ($request->status!="")?$request->status:"0";
                $nft_purchase_history->save();
                return response()->json(['status'=>'success','message'=>"Nft Purchase Requests update successfully..",'data'=>$nft_purchase_history]);
            }

            /* Search Functions start*/
            if($request->request_date && $request->request_date != ""){
                $date = date('Y-m-d',strtotime($request->request_date));
                $nft_purchase_history = $nft_purchase_history->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") = "'.$date.'"');
            }

            if($request->username && $request->username != ""){
                $nft_purchase_history = $nft_purchase_history->whereHas('user_detail',function($query) use ($request){
                    $query->where('username',$request->username);
                });
            }


            if($request->status && $request->status != ""){
            //     $status = ['Pending'=>'0','Processing'=>'3','On Sale'=>'2','Listing'=>'1'];
            //     $nft_purchase_history = $nft_purchase_history->where('status',$status[$request->status]);
            // }else{
            //     $data['status'] = 'On Sale';
                $nft_purchase_history = $nft_purchase_history->where('status',$request->status);
            }
            $nft_purchase_history = $nft_purchase_history->whereIn('status',[1,2,3,4,5,6,7]);

            $data['total_uploads'] = $nft_purchase_history->count();
            $data['total_sales'] = $nft_purchase_history->sum('sale_amount');

            /* Search Functions end*/
            $nft_purchase_history = $nft_purchase_history->orderBy('id','desc')->paginate($this->limit)->appends($request->all());

            return view('backend.nft_purchase_request.index',compact('nft_purchase_history','data'));
        } catch (Exception $e) {

            if($request->ajax()){
             return response()->json(['status'=>'fail','message'=>"Something went wrong......"]);

         }
      }
    }






    public function exportData(Request $request)
    {
        try {
            $nft_purchase_history = NftPurchaseHistory::with([
                'user_detail' => function ($query) {
                    $query->withTrashed();
                },
                'nftproduct',
            ]);

            if($request->ajax()){
                if($nft_purchase_history == null && $nft_purchase_history == ""){
                    return response()->json(['status'=>'fail','message'=>"{{trans('custom.no_data_found')}}...."]);
                }
                $nft_purchase_history->status = ($request->status!="")?$request->status:"0";
                $nft_purchase_history->save();
                return response()->json(['status'=>'success','message'=>"Nft Purchase Requests update successfully..",'data'=>$nft_purchase_history]);
            }

            /* Search Functions start*/
            if($request->request_date && $request->request_date != ""){
                $date = date('Y-m-d',strtotime($request->request_date));
                $nft_purchase_history = $nft_purchase_history->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") = "'.$date.'"');
            }

            if($request->username && $request->username != ""){
                $nft_purchase_history = $nft_purchase_history->whereHas('user_detail',function($query) use ($request){
                    $query->where('username',$request->username);
                });
            }


            if($request->status && $request->status != ""){
                $status = ['Pending'=>'0','Processing'=>'3','On Sale'=>'2','Listing'=>'1'];
                $nft_purchase_history = $nft_purchase_history->where('status',$status[$request->status]);
            }else{
                $data['status'] = 'On Sale';
                $nft_purchase_history = $nft_purchase_history->where('status','2');
            }

            $nft_purchase_history = $nft_purchase_history
                ->orderBy('id', 'desc')
                ->get();


            if (count($nft_purchase_history) > 0) {
                return (new \Rap2hpoutre\FastExcel\FastExcel(
                    $nft_purchase_history
                ))->download('Npr-' . time() . '.xlsx', function (
                    $nft_purchase_history
                ) {
                    return [
                        'Username' =>
                            $nft_purchase_history->user_detail->username,
                        'Product' => $nft_purchase_history->nftproduct->name,
                        'Amount' => number_format(
                            $nft_purchase_history->amount,
                            2
                        ),
                        'Order ID' => $nft_purchase_history->order_id ?? '',
                        'Purchase Date' => $nft_purchase_history->purchase_date
                            ? $nft_purchase_history->purchase_date
                            : date_format(
                                $nft_purchase_history->created_at,
                                'Y-m-d H:i:s'
                            ),
                        'Sell Date' => $nft_purchase_history->purchase_date
                            ? $nft_purchase_history->purchase_date
                            : date_format(
                                $nft_purchase_history->created_at,
                                'Y-m-d H:i:s'
                            ),
                        'Status' => ($nft_purchase_history->status == '3') ? ('Processing') : (($nft_purchase_history->status == '2') ? ('On Sale') : (($nft_purchase_history->status == '1') ? ('Listing') : ('Pending'))),
                    ];
                });
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'No Recored Found....');
            }
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
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
        if($request->type == "counteroffer"){
            $counteroffer = NftSellHistory::find($request->request_id);
            $user = User::find($counteroffer->user_id);
            $product = NftProduct::find($counteroffer->product_id);
            $counteroffer->counter_offer_amount = $request->counter_offer_amount;
            $counteroffer->remark = $request->remark;
            $counteroffer->status = 6;
            $counteroffer->counter_offer_status = 1;
            $counteroffer->counter_offer_verification_key = sha1($user->email.time());
            $counteroffer->save();

            $data['email'] = $user->email;
            $data['amount'] = $request->counter_offer_amount;
            $data['product'] = $product->name;
            $routeUrl = route('user.counterofferrequest',$counteroffer->counter_offer_verification_key);
            
            \Mail::send('emails.counteroffer',['routeUrl' =>$routeUrl,'data' => $data ], function($message) use($data)  {
                $message->to($data['email'], 'Counter Offer approve or reject')
                ->subject('Counter Offer Of '.$data['product']);
            });

            return redirect()->route('nft_purchase_request.index')->with(['success' => 'Counter Offer request place successfully.']);
        } else{
            if ($request->ajax() || $request->status != '') {
                try {
                    $change_status = NftSellHistory::find($id);
                    if ($change_status == null && $change_status == "") {
                        return response()->json(['status' => 'fail', 'message' => trans('custom.no_data_found')]);
                    }
                    if($request->status == 2){
                        $change_status->status = ($request->status != "") ? $request->status : "0";
                        $change_status->approve_date = Carbon::now();
                        $nftpurchase = NftPurchaseHistory::find($change_status->nft_purchase_history_id);
                        $nftpurchase->status = 2;
                        $nftpurchase->update();
                       
                    }else{
                        $change_status->status = ($request->status != "") ? $request->status : "0";
                        $nfttype = NftPurchaseHistory::find($change_status->nft_purchase_history_id);
                        $nfttype->type = 0;
                        $nfttype->save();
                    }
                    $change_status->save();
                    return response()->json(['status' => 'success', 'message' => "Crypto wallet transaction update successfully..", 'data' => $change_status]);
                } catch (Exception $e) {
                    return response()->json(['status' => 'fail', 'message' => "Something went wrong......"]);
                }
            }
            return response()->json($id);
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
    }
}
