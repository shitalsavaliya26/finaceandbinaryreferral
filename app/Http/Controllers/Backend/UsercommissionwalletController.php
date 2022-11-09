<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommissionWalletHistory;
// use App\Models\NftWallet;
use App\Models\UserWallet;
use App\Models\User;
use Carbon\Carbon;

class UsercommissionwalletController extends Controller
{
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
        $history_data = ['user_id'=>$request->user_id,'description'=>$request->description];
    	$user_detail = User::with('userwallet')->find($request->user_id);

         if($user_detail->userwallet==null){
            $user_detail->userwallet = UserWallet::firstOrCreate(['user_id'=>$request->user_id]);
        }

    	if($user_detail!=null && $user_detail!="" && $user_detail->userwallet!=null){
    		$userwallet = UserWallet::where('user_id',$request->user_id)->first();
    		$fund_wallet_amount = $userwallet->commission_wallet;

    		if($userwallet->commission_wallet > $request->amount){
    			$history_data["type"]="0";
    			$fund_wallet_amount = $userwallet->commission_wallet - $request->amount; 
                $history_data["amount"]=$fund_wallet_amount;
    			$text = "Commission wallet update successfully";
                CommissionWalletHistory::create($history_data);
    		}else if($userwallet->commission_wallet < $request->amount){
    			$fund_wallet_amount = $request->amount - $userwallet->commission_wallet; 
    			$history_data["type"]="2";
                $history_data["amount"]=$fund_wallet_amount;
    			$text = "Commission wallet update successfully";
    		    CommissionWalletHistory::create($history_data);
    		}else{
    			$fund_wallet_amount = $request->amount; 
    			$text = "No changes updated on user commission wallet";
    		}
    		$userwallet->update(['commission_wallet'=>$request->amount]);

    		return redirect()->back()->with(['success'=>$text]);
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        $user = User::with('userwallet')->where('id',$id)->first();
        $commission_wallets = CommissionWalletHistory::where('user_id',$id)->paginate(3)->appends($request->all());
        \view()->share('commission_wallets',$commission_wallets);
        \view()->share('user',$user);
        \view()->share('tab_name','commission_wallets');
        return view('backend.users.detail');
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
