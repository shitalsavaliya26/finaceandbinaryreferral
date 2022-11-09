<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoWallet;

class CryptoWalletsPaymentController extends Controller
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

        $crypto_wallets_payment_history =  CryptoWallet::with(['user_detail' => function ($query) {
            $query->withTrashed();
        }]);
    
        if($request->status && $request->status != ""){
            if($request->status == 1){
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('status','1')->where('type','!=','3');
            }elseif($request->status == 2){
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('status','2');
            }elseif($request->status == 3){
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('status','0');
            }else {
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('status','1')->where('type','3');
            }
        }
        if($request->type && $request->type != ""){
            if ($request->type == 1) {
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','0');
            }elseif($request->type == 2){
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','1');
            } elseif($request->type == 3){
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','2');
            } elseif($request->type == 4){
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','3');
            } else {
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','4');
            }
        }
        if($request->start && $request->end){
            $start_date = date('Y-m-d',strtotime($request->start));
            $end_date = date('Y-m-d',strtotime($request->end));

            $crypto_wallets_payment_history = $crypto_wallets_payment_history->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") >= "'.$start_date.'"')->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") <= "'.$end_date.'"');
        }
        $data = $request->all();
        $total_amount = $crypto_wallets_payment_history->sum('amount');
        $crypto_wallets_payment_history = $crypto_wallets_payment_history->orderBy('action_date','desc')->paginate($this->limit)->appends($data);
        return view('backend.crypto_wallets_payment_history.index',compact('crypto_wallets_payment_history','total_amount','data'));
    }


     //Crypto Wallets Payment History export
     public function exportData(Request $request)
     {
         try {
            
            $crypto_wallets_payment_history =  CryptoWallet::with(['user_detail' => function ($query) {
                $query->withTrashed();
            }]);
        
            if($request->status && $request->status != ""){
                if($request->status == 1){
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('status','1')->where('type','!=','3');
                }elseif($request->status == 2){
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('status','2');
                }elseif($request->status == 3){
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('status','0');
                }else {
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('status','1')->where('type','3');
                }
            }
            if($request->type && $request->type != ""){
                if ($request->type == 1) {
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','0');
                }elseif($request->type == 2){
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','1');
                } elseif($request->type == 3){
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','2');
                } elseif($request->type == 4){
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','3');
                } else {
                    $crypto_wallets_payment_history = $crypto_wallets_payment_history->where('type','4');
                }
            }
            if($request->start && $request->end){
                $start_date = date('Y-m-d',strtotime($request->start));
                $end_date = date('Y-m-d',strtotime($request->end));
    
                $crypto_wallets_payment_history = $crypto_wallets_payment_history->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") >= "'.$start_date.'"')->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") <= "'.$end_date.'"');
            }
            $crypto_wallets_payment_history = $crypto_wallets_payment_history->orderBy('action_date','desc')->get();

            if(count( $crypto_wallets_payment_history ) > 0){
                return ((new \Rap2hpoutre\FastExcel\FastExcel($crypto_wallets_payment_history))->download('cwph-' . time() . '.xlsx', function ($crypto_wallets_payment_history) {
                    return [
                        'Username' => $crypto_wallets_payment_history->user_detail->username,
                        'Date' => ($crypto_wallets_payment_history->action_date) ? ($crypto_wallets_payment_history->action_date) : (date_format($crypto_wallets_payment_history->created_at,"Y-m-d H:i:s")),
                        'Type' => ($crypto_wallets_payment_history->type == 0) ? ('USDT') : (($crypto_wallets_payment_history->type == 1) ? ('Malasian Payment') : ( ($crypto_wallets_payment_history->type == 2) ? ("CoinPayment") : (($crypto_wallets_payment_history->type == 3) ? ("Admin Added") : ("Admin Reduced")))),



                        'Amount' => number_format($crypto_wallets_payment_history->amount,2),
                        'Order ID' => $crypto_wallets_payment_history->order_id ?? '',
                        'Transaction ID' => $crypto_wallets_payment_history->transaction_id ?? '',
                        'Status' =>  ($crypto_wallets_payment_history->type == 3) ? ("Added") : (($crypto_wallets_payment_history->status == 1) ? ("Approved") : (($crypto_wallets_payment_history->status == 2) ? ("Rejected") : ("Pending"))),
                    ];
                }));
            }
            else{
                return redirect()->back()->with('error','No Recored Found....');
            }
         } catch (Exception $e) {
                 return redirect()->back()->with('error',$e->getMessage());          
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
