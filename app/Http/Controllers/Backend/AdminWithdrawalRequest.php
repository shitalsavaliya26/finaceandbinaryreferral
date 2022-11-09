<?php

namespace App\Http\Controllers\Backend;

use App\Models\Country;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Models\WithdrawalRequest;
use App\Http\Controllers\Controller;


class AdminWithdrawalRequest extends Controller
{
    /**
        * Handle the incoming request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
    */
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
        $withdrawal_requests  = WithdrawalRequest::with(['user_detail'=>function($q){
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

        if($request->type != ""){
            if($request->type == "1"){
                $withdrawal_requests = $withdrawal_requests->where('type','0');
            }
            else{
                $withdrawal_requests = $withdrawal_requests->where('type','1');
            }
        }
        if($request->search && $request->search != ""){
            $withdrawal_requests = $withdrawal_requests->whereHas('user_detail',function($query) use ($request){
                $query->where('username','like','%'.$request->search.'%');
            });
        }
        $countries = Country::pluck('country_name','id');
        $total_amount = $withdrawal_requests->whereNotIn('status',['3','4'])->sum('withdrawal_amount');

    	$withdrawal_requests= $withdrawal_requests->whereNotIn('status',['3','4'])->orderBy('action_date','desc')->paginate($this->limit)->appends($request->all());
    	$data = $request->all();
    	return view('backend.withdrawal_request.index',compact('withdrawal_requests','data','countries','total_amount'));
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
        try {
            if($id!='bulk-update'){
        		$withdrawal_request  = WithdrawalRequest::where('id',$request->request_id)->with(['user_detail'=>function($q){
    	    		$q->with(['userbank']);
    	    	}])->first();
    	    	if($withdrawal_request){
    	    		if($request->status == 1 && $request->transaction_id && $request->transaction_id !=""){
    	    			$withdrawal_request->transaction_id  = $request->transaction_id;
    	    		}
                    if($request->status == 2 || $request->status == '2' ){
                        $user_wallet = UserWallet::where('user_id',$withdrawal_request->user_id)->increment('withdrawal_balance',$withdrawal_request->withdrawal_amount);
                    }
    				$withdrawal_request->status  = $request->status;
    				$withdrawal_request->remark  = $request->remark;
    				$withdrawal_request->save();
    	    		return redirect()->route('withdrawal_request.index')->with('success','Withdrawal Request update successfully.');
    	    	}else{
    	    		return redirect()->back()->with('error','Withdrawal Request not found.');
    	    	}
            }else{
                $ids = array_unique($request->withdraw_request_id);
                WithdrawalRequest::whereIn('id',$ids)->update(['status'=>$request->status]);
                $withdrawal_request  = WithdrawalRequest::whereIn('id',$ids)->get();
                if($request->status == '1'){
                    return redirect()->route('withdrawal_request.index')->with('success','Selected transactions are approved.');
                }else{

                    foreach ($ids as $key => $value) {
                        if($value == null){
                            continue;
                        }
                       $withdrawal_request_value  = WithdrawalRequest::where('id',$value)->first();
                       // dd($value);
                       $user_wallet = UserWallet::where('user_id',$withdrawal_request_value->user_id)->increment('withdrawal_balance',$withdrawal_request_value->withdrawal_amount);
                    }                    
                    return redirect()->route('withdrawal_request.index')->with('success','Selected transactions are rejected.');
                }
                return redirect()->route('withdrawal_request.index')->with('error','Something went wrong......');
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
            $proof= WithdrawalRequest::find($request->wrid);
            $view = view('backend.withdrawal_request.partials.bank_proof',compact('proof','type'))->render();
            return response()->json(['status'=>'success','html'=>$view]);  
        } else {
            return response()->json(['status' => 'fail']);
        }
    }

    //exportdata Withdrawal Requests
    public function exportData(Request $request)
    {
        
        try {
            $withdrawal_requests  = WithdrawalRequest::with(['user_detail'=>function($q){
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
          
            if($request->type != ""){
                if($request->type == "1"){
                    $withdrawal_requests = $withdrawal_requests->where('type','0');
                }
                else{
                    $withdrawal_requests = $withdrawal_requests->where('type','1');
                }
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
                        'Amount' => number_format($withdrawal_requests->payble_amount,2),

                        'Bank Detail' => ($withdrawal_requests->type=='0')?(($withdrawal_requests->user_detail->userbank!=null) ? ("
                            Name:".$withdrawal_requests->user_detail->userbank->name.",Branch:".$withdrawal_requests->user_detail->userbank->branch.",Account Holder name :".$withdrawal_requests->user_detail->userbank->account_holder.",Account Number:".$withdrawal_requests->user_detail->userbank->account_number.",Swift Code:".$withdrawal_requests->user_detail->userbank->swift_code) : ("No bank available")):((!empty($withdrawal_requests->payment_address)) ? ("USDT Address :".$withdrawal_requests->payment_address) : ("No USDT Address Found")),
                        'Updated date' => ($withdrawal_requests->action_date ?? ""),
                        'Request Type' => ($withdrawal_requests->type =='1')?("USDT"):("Bank"),
                        'Status' => ($withdrawal_requests->status=='1') ? ("Approved") : (($withdrawal_requests->status=='2') ? ("Rejected") : ("Pending")),
                    ];
                }));
            }
            else{
                return redirect()->back()->with('error','No Recored Found....');
            }



            // if(count($withdrawal_requests) > 0){
            //     // $file_name = public_path('uploads/withdrawal_request/export/'.time().'.xlsx');
            //     // $path = public_path("uploads/withdrawal_request/export");
            //     // if(!\File::isDirectory($path)) {
            //         // \File::makeDirectory($path,  $mode = 0755, $recursive = true);
            //     // }
            //     // $setting = Helper::getSettings();
            //     $files = (new \Rap2hpoutre\FastExcel\FastExcel($withdrawal_requests))->export($file_name,function ($user) {
            //         $status = ['0'=>"Pending",'1'=>"Approved",'2'=>"Rejected"];
            //         $payble_amount = $user->payble_amount;
            //         // $setting = Helper::getSettings();
            //         $bank_detail="";

            //         // $account_number = strlen(trim($user->user_detail->userbank->account_number));
            //             $ac_num = (string)$user->user_detail->userbank->account_number;
            //             // for ($i=0; $i <$account_number ; $i++) { 
            //             //     $ac_num .= 'X';
            //             // }
            //         if( $user->type =='0' && $user->user_detail->userbank!=null){
            //             $bank_detail .= "Bank Name :".$user->user_detail->userbank->name;
            //             $bank_detail .= " | Branch :".$user->user_detail->userbank->branch;
            //             $bank_detail .= " | Account Holder name :".$user->user_detail->userbank->account_holder;
    
            //             $bank_detail .= " | Account Number :".$ac_num;
            //             $bank_detail .= " | Swift Code :".$user->user_detail->userbank->swift_code;
            //             $payble_amount = $payble_amount;// * $setting['withdrawal_rmb_amount']
            //         }else if($user->type =='1' && $user->user_detail!=null){
            //             $bank_detail = "Bank Name: USDT | Acc Holder Name: ".$user->user_detail->name." | USDT Address : ".$user->user_detail->usdt_address;
            //             if($user->payment_address){
            //                 $bank_detail = "Bank Name: USDT | Acc Holder Name: ".$user->user_detail->name." | USDT Address : ".$user->payment_address;
    
            //             }
            //             $payble_amount = $payble_amount ;//* $setting['bank_usdt_amount']
            //         }else if($user->type =='2'){
            //             $payble_amount = $payble_amount;// * $setting['bank_hkd_amount']
            //         }
            //         $USDTfunds = 'No'; 
            //         if($user->user_detail->usdt_withdraw){
            //             if($user->user_detail->usdt_fund_history->count() > 0){
            //                 $USDTfunds = 'Yes';
            //             } 
            //         }
            //         if( $user->type =='0'){
            //             return [
            //                 'Username' => $user->user_detail->username,
            //                 'Amount' => number_format($payble_amount,2),
            //                 'Updated date' => ($user->action_date),
            //                 'Bank Name' => @$user->user_detail->userbank->name,
            //                 'Account Holder Name' => @$user->user_detail->userbank->account_holder,
            //                 'Account Number' => @(string)$ac_num,
            //                 'Branch' => @$user->user_detail->userbank->branch,
            //                 // 'USDT Funds' => $USDTfunds,
            //                 // 'USDT Addess' => ''
            //             ];
            //         }else if($user->type =='1' && $user->user_detail!=null){
            //             return [
            //                 'Username' => $user->user_detail->username,
            //                 // 'Withdrawal Amount' => number_format($user->withdrawal_amount,2),
            //                 'Amount' => number_format($payble_amount,2),
            //                 'Updated date' => ($user->action_date),
            //                 'Bank Name' => 'USDT(ERC-20)',
            //                 'Account Holder Name' => '',
            //                 'Account Number' => '',
            //                 'Branch' => '',
            //                 // 'USDT Funds' => $USDTfunds,
            //                 // 'USDT Addess' => $user->payment_address
            //             ];
            //         }else if($user->type =='4' && $user->user_detail!=null){
            //             return [
            //                 'Username' => $user->user_detail->username,
            //                 // 'Withdrawal Amount' => number_format($user->withdrawal_amount,2),
            //                 'Amount' => number_format($payble_amount,2),
            //                 'Updated date' => ($user->action_date),
            //                 'Bank Name' => 'USDT(TRC-20)',
            //                 'Account Holder Name' => '',
            //                 'Account Number' => '',
            //                 'Branch' => '',
            //                 // 'USDT Funds' => $USDTfunds,
            //                 // 'USDT Addess' => $user->payment_address
            //             ];
            //         }else if($user->type =='2'){
            //             return [
            //                 'Username' => $user->user_detail->username,
            //                 // 'Withdrawal Amount' => number_format($user->withdrawal_amount,2),
            //                 'Amount' => number_format($payble_amount,2),
            //                 'Updated date' => ($user->action_date),
            //                 'Bank Name' => 'OMINI',
            //                 'Account Holder Name' => '',
            //                 'Account Number' => '',
            //                 'Branch' => '',
            //                 // 'USDT Funds' => $USDTfunds,
            //                 // 'USDT Addess' => ''
            //             ];
            //         }
            //     });
            //     return response()->download($file_name);     
            // }
            // else{
            //     return redirect()->back()->with('error','No Recored Found....');
            // }
        } catch (Exception $e) {
                return redirect()->back()->with('error',$e->getMessage());          
        }   
    }
}
