<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\UserWallet;
use App\Models\NftWithdrawalRequest;


class AdminNftWithdrawalRequest extends Controller
{
     public function __construct(Request $request){
        // parent::__construct();
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
        $withdrawal_requests  = NftWithdrawalRequest::with(['user_detail'=>function($q){
            $q->with(['userbank']);
        }])->whereHas('user_detail'); 

         if($request->start && $request->end){
            $start_date = date('Y-m-d',strtotime($request->start));
            $end_date = date('Y-m-d',strtotime($request->end));
            $withdrawal_requests = $withdrawal_requests->whereRaw('DATE_FORMAT(action_date,"%Y-%m-%d") >= "'.$start_date.'"')->whereRaw('DATE_FORMAT(action_date,"%Y-%m-%d") <= "'.$end_date.'"');
        }
        if($request->status && $request->status != ""){
            $status = ['Pending'=>'0','Approved'=>'1','Rejected'=>'2']; 
            $withdrawal_requests = $withdrawal_requests->where('status',$status[$request->status]);
        }
        if($request->country && $request->country != ""){
            $withdrawal_requests = $withdrawal_requests->whereHas('user_detail',function($query) use ($request){
                $query->where('country_id',$request->country);
            });
        }

        if($request->search && $request->search != ""){
            $withdrawal_requests = $withdrawal_requests->whereHas('user_detail',function($query) use ($request){
                $query->where('username','like','%'.$request->search.'%');
            });
        }
        $countries = Country::pluck('country_name','id');

        $withdrawal_requests= $withdrawal_requests->whereNotIn('status',['3','4'])->orderBy('created_at','desc')->paginate($this->limit)->appends($request->all());
        $data = $request->all();
        return view('backend.nft_withdrawal_request.index',compact('withdrawal_requests','data','countries'));
    }

     public function update(Request $request, $id)
    {
        try {
            if($id!='bulk-update'){
                $withdrawal_request  = NftWithdrawalRequest::where('id',$request->request_id)->with(['user_detail'=>function($q){
                    $q->with(['userbank']);
                }])->first();
                if($withdrawal_request){
                    if($request->status == 1 && $request->transaction_id && $request->transaction_id !=""){
                        $withdrawal_request->transaction_id  = $request->transaction_id;
                        $withdrawal_request->nftproduct->product_status = 'Withdrawn';
                        $withdrawal_request->nftproduct->save();
                    }
                    if($request->status == 2 || $request->status == '2' ){
                        // $user_wallet = UserWallet::where('user_id',$withdrawal_request->user_id)->increment('withdrawal_balance',$withdrawal_request->withdrawal_amount);
                    }
                    $withdrawal_request->status  = $request->status;
                    $withdrawal_request->remark  = $request->remark;
                    $withdrawal_request->save();
                    return redirect()->route('nft_withdrawal_request.index')->with('success','Withdrawal Request update successfully.');
                }else{
                    return redirect()->back()->with('error','Withdrawal Request not found.');
                }
            }else{
                $ids = array_unique($request->withdraw_request_id);
                NftWithdrawalRequest::whereIn('id',$ids)->update(['status'=>$request->status]);
                $withdrawal_request  = NftWithdrawalRequest::whereIn('id',$ids)->get();
                if($request->status == '1'){
                     foreach ($ids as $key => $value) {
                        if($value == null){
                            continue;
                        }
                        $withdrawal_request_value  = NftWithdrawalRequest::where('id',$value)->first();
                        $withdrawal_request_value->nftproduct->product_status = 'Withdrawn';
                        $withdrawal_request_value->nftproduct->save();
                       // dd($value);
                       // $user_wallet = UserWallet::where('user_id',$withdrawal_request_value->user_id)->increment('withdrawal_balance',$withdrawal_request_value->withdrawal_amount);
                    }     
                    return redirect()->route('nft_withdrawal_request.index')->with('success','Selected transactions are approved.');
                }else{

                    foreach ($ids as $key => $value) {
                        if($value == null){
                            continue;
                        }
                       $withdrawal_request_value  = NftWithdrawalRequest::where('id',$value)->first();
                       // dd($value);
                       // $user_wallet = UserWallet::where('user_id',$withdrawal_request_value->user_id)->increment('withdrawal_balance',$withdrawal_request_value->withdrawal_amount);
                    }                    
                    return redirect()->route('nft_withdrawal_request.index')->with('success','Selected transactions are rejected.');
                }
                return redirect()->route('nft_withdrawal_request.index')->with('error','Something went wrong......');
            }
        } catch (Exception $e) {
                return redirect()->back()->with('error',$e->getMessage());          
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

    //bank proof show in modal
    public function bank_proofs(Request $request)
    {
        if ($request->wrid && $request->wrid != '') {
            $type = $request->type?$request->type:0;
            $proof= NftWithdrawalRequest::find($request->wrid);
            $view = view('backend.nft_withdrawal_request.partials.bank_proof',compact('proof','type'))->render();
            return response()->json(['status'=>'success','html'=>$view]);  
        } else {
            return response()->json(['status' => 'fail']);
        }
    }

    //exportdata Withdrawal Requests
    public function exportData(Request $request)
    {
        
        try {
            $withdrawal_requests  = NftWithdrawalRequest::with(['user_detail'=>function($q){
                $q->with(['userbank']);
            }])->whereHas('user_detail'); 
    
             if($request->start && $request->end){
                $start_date = date('Y-m-d',strtotime($request->start));
                $end_date = date('Y-m-d',strtotime($request->end));
                $withdrawal_requests = $withdrawal_requests->whereRaw('DATE_FORMAT(action_date,"%Y-%m-%d") >= "'.$start_date.'"')->whereRaw('DATE_FORMAT(action_date,"%Y-%m-%d") <= "'.$end_date.'"');
            }
            if($request->status && $request->status != ""){
                $status = ['Pending'=>'0','Approved'=>'1','Rejected'=>'2']; 
                $withdrawal_requests = $withdrawal_requests->where('status',$status[$request->status]);
            }
            if($request->country && $request->country != ""){
                $withdrawal_requests = $withdrawal_requests->whereHas('user_detail',function($query) use ($request){
                    $query->where('country_id',$request->country);
                });
            }

            if($request->search && $request->search != ""){
                $withdrawal_requests = $withdrawal_requests->whereHas('user_detail',function($query) use ($request){
                    $query->where('username','like','%'.$request->search.'%');
                });
            }
    
            $withdrawal_requests= $withdrawal_requests->whereNotIn('status',['3','4'])->orderBy('action_date','desc')->get();
            
            
            if(count( $withdrawal_requests ) > 0){
                return ((new \Rap2hpoutre\FastExcel\FastExcel($withdrawal_requests))->download('withdrawalrequests -' . time() . '.xlsx', function ($withdrawal_requests) {
                    return [
                        'Username' => $withdrawal_requests->user_detail->username,
                        'NFT' => $withdrawal_requests->nftproduct->name,
                        'NFT Category' => $withdrawal_requests->nftproduct->nftcategory->name,
                        'Updated date' => ($withdrawal_requests->action_date ?? ""),
                        'Status' => ($withdrawal_requests->status=='1') ? ("Approved") : (($withdrawal_requests->status=='2') ? ("Rejected") : ("Pending")),
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
}
