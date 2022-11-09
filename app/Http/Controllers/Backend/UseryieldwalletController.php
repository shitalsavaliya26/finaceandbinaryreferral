<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\YieldWalletHistory;
// use App\Models\NftWallet;
use App\Models\UserWallet;
use Carbon\Carbon;

class UseryieldwalletController extends Controller
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
    		$fund_wallet_amount = $userwallet->yield_wallet;

    		if($userwallet->yield_wallet > $request->amount){
    			$history_data["type"]="0";
                $history_data["stacking_pool_id"]=0;
    			$fund_wallet_amount = $userwallet->yield_wallet - $request->amount; 
                $history_data["amount"]=$fund_wallet_amount;
    			$text = "Yield wallet update successfully";
                YieldWalletHistory::create($history_data);
    		}else if($userwallet->yield_wallet < $request->amount){
    			$fund_wallet_amount = $request->amount - $userwallet->yield_wallet; 
    			$history_data["type"]="2";
                $history_data["stacking_pool_id"]=0;
                $history_data["amount"]=$fund_wallet_amount;
    			$text = "Yield wallet update successfully";
    		    YieldWalletHistory::create($history_data);
    		}else{
    			$fund_wallet_amount = $request->amount; 
    			$text = "No changes updated on user yield wallet";
    		}
    		$userwallet->update(['yield_wallet'=>$request->amount]);

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
        $yield_wallets = YieldWalletHistory::where('user_id',$id)->paginate(3)->appends($request->all());
        \view()->share('yield_wallets',$yield_wallets);
        \view()->share('user',$user);
        \view()->share('tab_name','yield_wallets');
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
