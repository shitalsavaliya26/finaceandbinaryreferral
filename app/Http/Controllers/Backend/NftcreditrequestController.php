<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NftWallet;
use App\Models\Country;
use App\Models\UserWallet;
use Carbon\Carbon;

class NftcreditrequestController extends Controller
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
        try{
            $data = $request->all();
            $crypto_credit =  NftWallet::with(['user_detail' => function ($query) {
                $query->withTrashed();
            }]);
            if($request->ajax()){
                if($crypto_credit == null && $crypto_credit == ""){
                    return response()->json(['status'=>'fail','message'=>"{{trans('custom.no_data_found')}}...."]);
                }
                $crypto_credit->status = ($request->status!="")?$request->status:"0";
                $crypto_credit->save();
                return response()->json(['status'=>'success','message'=>"Nft wallet transaction update successfully..",'data'=>$crypto_credit]);
            }  
            /* Search Functions start*/
            if($request->request_date && $request->request_date != ""){
                $date = date('Y-m-d',strtotime($request->request_date));
                $crypto_credit = $crypto_credit->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") = "'.$date.'"');
            }

            if($request->username && $request->username != ""){
                $crypto_credit = $crypto_credit->whereHas('user_detail',function($query) use ($request){
                    $query->where('username',$request->username);
                });
            }

            if($request->status && $request->status != ""){
                $status = ['Pending'=>'0','Approved'=>'1','Rejected'=>'2']; 
                $crypto_credit = $crypto_credit->where('status',$status[$request->status]);
            }else{
                $data['status'] = 'Pending';
                $crypto_credit = $crypto_credit->where('status','0');
            }

            if($request->remark && $request->remark != ""){
                $crypto_credit = $crypto_credit->where('remark','Like','%'.$request->remark.'%');
            }

            $data['total_uploads'] = $crypto_credit->whereIn('type',['0'])->count();
            $data['total_sales'] = $crypto_credit->whereIn('type',['0'])->sum('amount');

            /* Search Functions end*/
            $crypto_credit = $crypto_credit->whereIn('type',['2','0','7'])->orderBy('created_at','desc')->paginate($this->limit)->appends($request->all()); 
            
            return view('backend.nft_wallets_credit_request.index',compact('crypto_credit','data'));
        } catch (Exception $e) {

            if($request->ajax()){
             return response()->json(['status'=>'fail','message'=>"Something went wrong......"]);

         }
        }
    }


   
     //Nft Wallets Payment History export
     public function exportData(Request $request)
     {
         try {
            
            $data = $request->all();
            $crypto_credit =  NftWallet::with(['user_detail' => function ($query) {
                $query->withTrashed();
            }]);
            if($request->ajax()){
                if($crypto_credit == null && $crypto_credit == ""){
                    return response()->json(['status'=>'fail','message'=>"{{trans('custom.no_data_found')}}...."]);
                }
                $crypto_credit->status = ($request->status!="")?$request->status:"0";
                $crypto_credit->save();
                return response()->json(['status'=>'success','message'=>"Nft wallet transaction update successfully..",'data'=>$crypto_credit]);
            }  
            /* Search Functions start*/
            if($request->request_date && $request->request_date != ""){
                $date = date('Y-m-d',strtotime($request->request_date));
                $crypto_credit = $crypto_credit->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") = "'.$date.'"');
            }

            if($request->username && $request->username != ""){
                $crypto_credit = $crypto_credit->whereHas('user_detail',function($query) use ($request){
                    $query->where('username',$request->username);
                });
            }

            if($request->status && $request->status != ""){
                $status = ['Pending'=>'0','Approved'=>'1','Rejected'=>'2']; 
                $crypto_credit = $crypto_credit->where('status',$status[$request->status]);
            }else{
                $data['status'] = 'Pending';
                $crypto_credit = $crypto_credit->where('status','0');
            }

            if($request->remark && $request->remark != ""){
                $crypto_credit = $crypto_credit->where('remark','Like','%'.$request->remark.'%');
            }

            $data['total_uploads'] = $crypto_credit->whereIn('type',['0'])->count();
            $data['total_sales'] = $crypto_credit->whereIn('type',['0'])->sum('amount');

            /* Search Functions end*/
            $crypto_credit = $crypto_credit->whereIn('type',['2','0','7'])->orderBy('action_date','desc')->get();
            
            
            if(count( $crypto_credit ) > 0){
                return ((new \Rap2hpoutre\FastExcel\FastExcel($crypto_credit))->download('nwcr-' . time() . '.xlsx', function ($crypto_credit) {
                    return [
                        '#Id' => str_replace("-", "", $crypto_credit->created_at->format('d-m-y'))."-".sprintf("%04d", $crypto_credit->unique_no),
                        'Type' => ($crypto_credit->type==7)? (($crypto_credit->user_detail && $crypto_credit->user_detail->country_id == '45') ? 'RMB' : 'IDR'):'USDT',
                        'Username' => $crypto_credit->user_detail!=null?$crypto_credit->user_detail->username:"",
                        'Credits' => number_format($crypto_credit->amount,2),
                        'Remark' => ($crypto_credit->remark ?? " "),
                        'Date' => date_format($crypto_credit->created_at,"Y-m-d H:i:s"),
                        'Status' =>  ($crypto_credit->status == 1) ? ("Approved") : ( ($crypto_credit->status == 2) ? ("Rejected") : ("Pending")),
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
        if($request->ajax() || $request->status != ''){
            try{
                $fund_wallet = NftWallet::find($id);
                if($fund_wallet == null && $fund_wallet == ""){
                    return response()->json(['status'=>'fail','message'=>"{{trans('custom.no_data_found')}}...."]);
                }
                $fund_wallet->status = ($request->status!="")?$request->status:"0";
                if($request->status == 1 || $request->status == '1'){
                    $user_wallet = UserWallet::where('user_id',$fund_wallet->user_id)->increment('nft_wallet',$fund_wallet->amount);

                   
                }
                $date = date('d-m-y');
                $count = NftWallet::where('user_id',$fund_wallet->user_id)->where('status',1)->count();
                $fund_wallet->action_date = Carbon::now();
                if(!empty($request->remark)){
                    $fund_wallet->remark = ($request->remark) ? $request->remark : null;
                }
                $fund_wallet->save(); 
                if($request->status == '2'){
                    return redirect()->back()->with('success','Rejected successfully..');
                }
                return response()->json(['status'=>'success','message'=>"Nft wallet transaction update successfully..",'data'=>$fund_wallet]);
            } catch (Exception $e) {
                return response()->json(['status'=>'fail','message'=>"Something went wrong......"]);
            }               
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
