<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YieldWalletHistory;

class YieldWalletController extends Controller
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
        //
        $yield_wallet_payment = YieldWalletHistory::with('user_detail');
        if($request->status && $request->status != ""){
            if($request->status == 1){
                $yield_wallet_payment = $yield_wallet_payment->where('type','=','2');
            }
            else{
                $yield_wallet_payment = $yield_wallet_payment->where('type','=','0');
            }
        }
        if($request->start && $request->end){
            $start_date = date('Y-m-d',strtotime($request->start));
            $end_date = date('Y-m-d',strtotime($request->end));
            $yield_wallet_payment = $yield_wallet_payment->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") >= "'.$start_date.'"')->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") <= "'.$end_date.'"');
        }
        $data = $request->all();
        $total_amount = $yield_wallet_payment->sum('amount');
        $yield_wallet_payment = $yield_wallet_payment->orderBy('id','desc')->paginate($this->limit)->appends($data);
        return view('backend.yield_wallet.yield_wallet_history',compact('yield_wallet_payment','total_amount','data'));
    }


    //Yield Wallet History export
    public function exportData(Request $request)
    {
        try {
           
            $yield_wallet_payment = YieldWalletHistory::with('user_detail');
            if($request->status && $request->status != ""){
                if($request->status == 1){
                    $yield_wallet_payment = $yield_wallet_payment->where('type','=','2');
                }
                else{
                    $yield_wallet_payment = $yield_wallet_payment->where('type','=','0');
                }
            }
            if($request->start && $request->end){
                $start_date = date('Y-m-d',strtotime($request->start));
                $end_date = date('Y-m-d',strtotime($request->end));
                $yield_wallet_payment = $yield_wallet_payment->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") >= "'.$start_date.'"')->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") <= "'.$end_date.'"');
            }
            $yield_wallet_payment = $yield_wallet_payment->orderBy('id','desc')->get();
            if(count( $yield_wallet_payment ) > 0){
                return ((new \Rap2hpoutre\FastExcel\FastExcel($yield_wallet_payment))->download('yield-Wallet-history-' . time() . '.xlsx', function ($yield_wallet_payment) {
                    return [
                        'Username' => $yield_wallet_payment->user_detail->username,
                        'Amount' => number_format($yield_wallet_payment->amount,2),
                        'Date' => date_format($yield_wallet_payment->created_at,"Y-m-d H:i:s"),
                        'Status' => $yield_wallet_payment->type == 2 ? 'Added' : 'reduce',
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
