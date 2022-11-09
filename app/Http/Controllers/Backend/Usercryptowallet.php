<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CryptoWalletHistory;
use App\Models\CryptoWallet;
use App\Models\UserWallet;
use Carbon\Carbon;

class Usercryptowallet extends Controller
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
                $history_data = ['user_id'=>$request->user_id,'description'=>$request->description];
                $user_detail = User::with('userwallet')->find($request->user_id);
                if($user_detail->userwallet==null){
                    $user_detail->userwallet = UserWallet::firstOrCreate(['user_id'=>$request->user_id]);
                }
                if($user_detail!=null && $user_detail!="" && $user_detail->userwallet!=null){
                    $userwallet = UserWallet::where('user_id',$request->user_id)->first();
                    $fund_wallet_amount = $userwallet->crypto_wallet;
                    $fundwalletdate = CryptoWallet::where('created_at', '>=', date('Y-m-d').' 00:00:00')->orderBy('id','DESC')->first();
                    $uniqu_no = 1;
                    if($fundwalletdate != null && !empty($fundwalletdate) ){
                        $uniqu_no = (!empty($fundwalletdate->unique_no)) ? $fundwalletdate->unique_no + 1 : 1;
                    }
                    if($userwallet->crypto_wallet > $request->amount){
                        $history_data["type"]="0";
                        $fund_wallet_amount = $userwallet->crypto_wallet - $request->amount; 
                        $history_data["amount"]=$fund_wallet_amount;
                        $text = "Crypto wallet update successfully";
                        CryptoWalletHistory::create($history_data);
                        if($fund_wallet_amount > 0){


                        $fundWallet = new CryptoWallet;
                        $fundWallet->user_id = $user_detail->id;
                        $fundWallet->amount = $fund_wallet_amount;
                        $fundWallet->usd_amount = $fund_wallet_amount;
                        $fundWallet->type = 4;
                        $fundWallet->action_date =Carbon::now();
                        $fundWallet->status = 1;
                        $fundWallet->unique_no = $uniqu_no;
                        $fundWallet->save();
                    }

                }
                else if($userwallet->crypto_wallet < $request->amount){
                    $fund_wallet_amount = $request->amount - $userwallet->crypto_wallet; 
                    $history_data["type"]="2";
                    $history_data["amount"]=$fund_wallet_amount;
                    $text = "Crypto wallet update successfully";
                    CryptoWalletHistory::create($history_data);
                    if($fund_wallet_amount > 0){
                            $fundWallet = new CryptoWallet;
                            $fundWallet->user_id = $user_detail->id;
                            $fundWallet->amount = $fund_wallet_amount;
                            $fundWallet->usd_amount = $fund_wallet_amount;
                            $fundWallet->type = 3;
                            $fundWallet->action_date = Carbon::now();
                            $fundWallet->status = 1;
                            $fundWallet->unique_no = $uniqu_no;
                            $fundWallet->save();
                            
                          
                        }
                    }else{
                        $fund_wallet_amount = $request->amount; 
                        $text = "No changes updated on user crypto wallet";
                    }
                    $userwallet->crypto_wallet =$request->amount;
                    $userwallet->save();
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
        $user = User::with('userwallet')->where('id',$id)->first();
        $crypto_wallets = CryptoWalletHistory::where('user_id',$id)->paginate(3)->appends($request->all());
        \view()->share('crypto_wallets',$crypto_wallets);
        \view()->share('user',$user);
        \view()->share('tab_name','crypto_wallets');
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
