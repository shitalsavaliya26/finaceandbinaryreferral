<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Package;
use App\Models\UserWallet;
use App\Models\StackingPool;
use App\Models\UserReferral;
use Illuminate\Http\Request;
use App\Models\NftSellHistory;
use App\Models\PairingCommission;
use App\Models\WithdrawalRequest;
use App\Models\NftPurchaseHistory;
use App\Models\ReferralCommission;
use App\Models\CommissionWalletHistory;
use App\Models\NftWithdrawalRequest;


class CommonController extends Controller
{
    public function pairingCommission(){
        set_time_limit(0);
        \Artisan::call('calculate:pairingcommissiontest');
        echo "executed";die();
    }

    public function referralCommission(){
        set_time_limit(0);
        \Artisan::call('calculate:directreferraltest 19');
        // $a = 1;
        // $command = "php artisan calculate:directreferral ".$a." > /dev/null 2>/dev/null &";
        // shell_exec($command);
        echo "executed";die();
        
    }

    public function soldRequest(){
        set_time_limit(0);
        \Artisan::call('nftproduct:selltesting');
        // $a = 1;
        // $command = "php artisan calculate:directreferral ".$a." > /dev/null 2>/dev/null &";
        // shell_exec($command);
        echo "executed";die();
        
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

     /** Check sponsor username **/
    protected function placementUsernameExists(Request $request){
        $usernameExits = User::where('username',$request->placement_username)->where('status','active')->exists();
        if ($usernameExits != null) {
            $placement = User::where('username',$request->placement_username)->where('status','active')->first();
            $placementCount = User::where('placement_id',$placement->id)->where('status','active')->count();
            if($placementCount >= 2){
                $isValid = false;
            }
            $user = User::where('username',$request->sponsor_check)->where('status','active')->first();
            $user_reference = UserReferral::where('user_id',$user->id)->first();
            // $upline_ids = $user_reference!=null?(array)$user_reference->downline_ids:[];
            $upline_ids = Helper::getAllDownlineIds($user->id);
            $isValid = false;
            // echo "<pre>";
            // print_r();
            //     die('test2');

            if($placementCount < 2 && $placement && (in_array($placement->id, $upline_ids) || empty($upline_ids) || $placement->username == $user->username) && $user->id <= $placement->id){
                $isValid = true;
            }

        } else {
                // die('test1');
            $isValid = false;
        }
        echo json_encode(array(
            'valid' => $isValid,
        ));
    }

    /***Check Username   */
    // protected function usernameExits(Request $request){
    //     $usernameExits = User::where('username',$request->username)->first();
    //     if ($usernameExits === null) {
    //         $isValid = true;
    //     } else {
    //         $isValid = false;
    //     }
    //     echo json_encode(array(
    //         'valid' => $isValid,
    //     ));
    // }

    /***Check email   */
    protected function emailExists(Request $request){
        $emailExits = User::where('email',$request->email)->first();
        if ($emailExits === null) {
            $isValid = true;
        } else {
            $isValid = false;
        }
        echo json_encode(array(
            'valid' => $isValid,
        ));
    }

    /***Check sponsor username  */
    protected function sponsorUsernameExists(Request $request)
    {
        $usernameExits = User::where('username', $request->sponsor_username)
            ->where('status', 'active')
            ->exists();
        if ($usernameExits != null) {
            $isValid = true;
        } else {
            $isValid = false;
        }
        echo json_encode([
            'valid' => $isValid,
        ]);
    }

    /***Check Ic Number Duplication   */
    protected function icNumberDuplication(Request $request)
    {
        $usernameExits = User::where('username', $request->sponsor_username)
            ->where('status', 'active')
            ->first();
        $icnumber = $request->ic_number;
        $icNUmberCheck = User::where('identification_number', $icnumber)
            ->where('status', 'active')
            ->count();
        $isValid = false;
        // return $icnumber;
        if ($icNUmberCheck >= 3) {
            return json_encode([
                'valid' => 'false',
            ]);
        }

        if ($usernameExits != null) {
            $checkIcnumbersameTree = $this->checkIcnumbersameTree(
                $usernameExits->id,
                $icnumber
            );
            if ($checkIcnumbersameTree == false) {
                echo json_encode([
                    'valid' => $isValid,
                ]);
                return;
            }
        }
        if ($icNUmberCheck >= 3) {
            $isValid = false;
        } elseif ($icNUmberCheck == 0) {
            $isValid = true;
        } else {
            if ($usernameExits != null) {
                $donwCont = $this->getdownIcnumber(
                    $usernameExits->id,
                    $icnumber
                );
                $upCount = $this->getuplineIcnumber(
                    $request->sponsor_username,
                    $icnumber
                );
                $isValid = false;
                if ($donwCont + $upCount < 3) {
                    $isValid = true;
                }
            } else {
                $isValid = false;
            }
        }

        echo json_encode([
            'valid' => $isValid,
        ]);
    }

    /***Check Ic Number Duplication   */
    protected function icNumberDuplicationedit(Request $request)
    {
        $usernameExits = User::where('username', $request->sponsor_username)
            ->where('status', 'active')
            ->first();
        $icnumber = $request->ic_number;
        $icNUmberCheck = User::where('identification_number', $icnumber)
            ->where('status', 'active')
            ->count();
        $isValid = false;
        // return $icnumber;
        if ($icNUmberCheck >= 3) {
            return json_encode([
                'valid' => 'false',
            ]);
        }

        if ($usernameExits != null) {
            $checkIcnumbersameTree = $this->checkIcnumbersameTree1(
                $usernameExits->id,
                $icnumber
            );
            if ($checkIcnumbersameTree == false) {
                echo json_encode([
                    'valid' => $isValid,
                ]);
                return;
            }
        }
        if ($icNUmberCheck >= 3) {
            $isValid = false;
        } elseif ($icNUmberCheck == 0) {
            $isValid = true;
        } else {
            if ($usernameExits != null) {
                $donwCont = $this->getdownIcnumber(
                    $usernameExits->id,
                    $icnumber
                );
                $upCount = $this->getuplineIcnumber(
                    $request->sponsor_username,
                    $icnumber
                );
                $isValid = false;
                if ($donwCont + $upCount < 3) {
                    $isValid = true;
                }
            } else {
                $isValid = false;
            }
        }

        echo json_encode([
            'valid' => $isValid,
        ]);
    }

    /**Check Icnumber same tree or not  */
    protected function checkIcnumbersameTree($userid, $icnumber)
    {
        $sponser_details = User::where('id', $userid)->first();
        $count = User::where('identification_number', $icnumber)
            ->where(['status' => 'active'])
            ->where('id', '!=', $sponser_details->id)
            ->count();
        $exists = 0;

        if ($count > 0) {
            $downline_ids = $upline_ids = [];
            $user_ids = User::where('identification_number', $icnumber)
                ->where(['status' => 'active'])
                ->pluck('id');
            $user_reference = UserReferral::where(
                'user_id',
                $sponser_details->id
            )->first();
            $downline_ids =
                $user_reference != null ? $user_reference->downline_ids : [];
            $upline_ids =
                $user_reference != null ? $user_reference->upline_ids : [];
            $normal_count = 0;
            $downline_count = 0;
            $downline_count = 0;
            if (
                ($downline_ids != null && is_array($downline_ids)) ||
                ($upline_ids != null && is_array($upline_ids))
            ) {
                foreach ($user_ids as $key => $value) {
                    if ($downline_count >= 3 || $normal_count >= 1) {
                        $exists = 1;
                        break;
                    }
                    if (
                        is_array($downline_ids) &&
                        in_array($value, $downline_ids)
                    ) {
                        $downline_count++;
                    } elseif (
                        is_array($upline_ids) &&
                        in_array($value, $upline_ids)
                    ) {
                        $downline_count++;
                    } elseif ($sponser_details->id == $value) {
                        $downline_count++;
                    } else {
                        $normal_count++;
                    }
                }
                if ($downline_count >= 3 || $normal_count >= 1) {
                    $exists = 1;
                }
                // print_r(['downline_count'=>$downline_count,'normal_count'=>$normal_count,'exists'=>$exists]);die();
            } else {
                $exists = 0;
            }
        }
        if ($exists) {
            return false;
        } else {
            return true;
        }

        // $firstIc = User::where('identification_number',$icnumber)->where('status','active')->where('is_deleted','0')->first();
        // if($firstIc){
        //     $useridfirst = $firstIc->id;
        // }else{
        //     $useridfirst = $userid;
        // }
        // $usernameExits = User::where('id',$userid)->where('status','active')->where('is_deleted','0')->first();
        // if($usernameExits != null){
        //     $allDownlineids = UserReferral::where('user_id',$useridfirst)->value('downline_ids');
        //     $allDownlineids = $allDownlineids!=null?$allDownlineids:[];
        //     $alluserExist = User::where('identification_number',$icnumber)->where('status','active')->where('is_deleted','0')->first();
        //     if($alluserExist != null && !empty($allDownlineids) && is_array($allDownlineids) && !in_array($usernameExits->id,$allDownlineids)){
        //         return false;
        //     }
        // }
        // return true;
    }

    /**Check Icnumber same tree or not  */
    protected function checkIcnumbersameTree1($userid, $icnumber)
    {
        $sponser_details = User::where('id', $userid)->first();
        $count = User::where('identification_number', $icnumber)
            ->where(['status' => 'active'])
            ->where('id', '!=', $sponser_details->id)
            ->count();
        $exists = 0;

        if ($count > 0) {
            $downline_ids = $upline_ids = [];
            $user_ids = User::where('identification_number', $icnumber)
                ->where(['status' => 'active'])
                ->pluck('id');
            $user_reference = UserReferral::where(
                'user_id',
                $sponser_details->id
            )->first();
            $downline_ids =
                $user_reference != null ? $user_reference->downline_ids : [];
            $upline_ids =
                $user_reference != null ? $user_reference->upline_ids : [];
            $normal_count = 0;
            $downline_count = 0;
            $downline_count = 0;
            if (
                ($downline_ids != null && is_array($downline_ids)) ||
                ($upline_ids != null && is_array($upline_ids))
            ) {
                foreach ($user_ids as $key => $value) {
                    if ($downline_count >= 3 || $normal_count > 1) {
                        $exists = 1;
                        break;
                    }
                    if (
                        is_array($downline_ids) &&
                        in_array($value, $downline_ids)
                    ) {
                        $downline_count++;
                    } elseif (
                        is_array($upline_ids) &&
                        in_array($value, $upline_ids)
                    ) {
                        $downline_count++;
                    } elseif ($sponser_details->id == $value) {
                        $downline_count++;
                    } else {
                        $normal_count++;
                    }
                }
                if ($downline_count >= 3 || $normal_count > 1) {
                    $exists = 1;
                }
                // print_r(['downline_count'=>$downline_count,'normal_count'=>$normal_count,'exists'=>$exists]);die();
            } else {
                $exists = 0;
            }
        }
        if ($exists) {
            return false;
        } else {
            return true;
        }

        // $firstIc = User::where('identification_number',$icnumber)->where('status','active')->where('is_deleted','0')->first();
        // if($firstIc){
        //     $useridfirst = $firstIc->id;
        // }else{
        //     $useridfirst = $userid;
        // }
        // $usernameExits = User::where('id',$userid)->where('status','active')->where('is_deleted','0')->first();
        // if($usernameExits != null){
        //     $allDownlineids = UserReferral::where('user_id',$useridfirst)->value('downline_ids');
        //     $allDownlineids = $allDownlineids!=null?$allDownlineids:[];
        //     $alluserExist = User::where('identification_number',$icnumber)->where('status','active')->where('is_deleted','0')->first();
        //     if($alluserExist != null && !empty($allDownlineids) && is_array($allDownlineids) && !in_array($usernameExits->id,$allDownlineids)){
        //         return false;
        //     }
        // }
        // return true;
    }

    /**Check downline and upline Ic number validation  */
    protected function getdownIcnumber($sponserId, $icnumber, $i = 1)
    {
        $usernameExits = User::where('sponsor_id', $sponserId)
            ->where('status', 'active')
            ->get();
        $icNUmberCheck = User::where('identification_number', $icnumber)
            ->where('status', 'active')
            ->first();
        // dd($sponserId);
        // dd($usernameExits);
        $downCount = 0;
        if (count($usernameExits)) {
            foreach ($usernameExits as $key => $value) {
                # code...
                if ($value->identification_number == $icnumber) {
                    $downCount = $i;
                    $i++;
                }
                $this->getdownIcnumber($value->id, $icnumber, $i);
            }
        }
        return $downCount;
    }

    protected function getuplineIcnumber($sponserName, $icnumber, $i = 1)
    {
        $usernameExits = User::where('username', $sponserName)
            ->where('status', 'active')
            ->first();
        $upCount = 0;
        if (!empty($usernameExits) || $usernameExits != null) {
            if ($usernameExits->identification_number == $icnumber) {
                $upCount = $i;
                $i++;
            }
            $this->getuplineIcnumber(
                $usernameExits->sponserName,
                $icnumber,
                $i
            );
        }
        return $upCount;
    }


      /***Check Username   */
    protected function usernameExits(Request $request){
        $usernameExits = User::where('username',$request->username)->first();
        if ($usernameExits === null) {
            $isValid = true;
        } else {
            $isValid = false;
        }
        echo json_encode(array(
            'valid' => $isValid,
        ));
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
    // withdrawlRequestVerify
    public function NftWithdrawalRequest(Request $request){
        $withderawRequest = NftWithdrawalRequest::where('usdt_verification_key',$request->key)->first();
        \Session::put('url1', $request->key);
        if (Auth::check()) {
            $user = Auth::user();
            // $user = User::find($withderawRequest->user_id);
            if($withderawRequest->user_id !=  $user->id){
                return redirect()->route('my_collection')->with(['error'=>trans('custom.withdraw_request_not_user')]);
            }
            if($withderawRequest){
                if($withderawRequest->status != 3 ){
                    return redirect()->route('my_collection')->with(['error'=>trans('custom.withdrawl_request_already_verified')]);    
                }
                $withderawRequest->status = 0;
                $withderawRequest->action_date = Carbon::now();
                $withderawRequest->save();
                return redirect()->route('my_collection')->with(['success'=>trans('custom.withdrawl_request_verified')]);
            }
            return redirect()->route('my_collection')->with(['error'=>trans('custom.withdrawl_request_not_valid')]);
        }
        return redirect()->route('login')->with(['error'=>trans('custom.login_first')]);
    }


     //counter offer approve or reject.
     public function counterofferrequest(Request $request){
        // dd($request->get('status'),$request->key);
        $counteroffer = NftSellHistory::where('counter_offer_verification_key',$request->key)->first();
        if($counteroffer->counter_offer_status == 1){
            if($request->get('status') == "approve"){
                $counteroffer->sale_amount = $counteroffer->counter_offer_amount;
                $counteroffer->status = 2;
                $counteroffer->counter_offer_status = 2;
                $counteroffer->approve_date = Carbon::now();
                $counteroffer->update();

                $nftpurchase = NftPurchaseHistory::find($counteroffer->nft_purchase_history_id);
                $nftpurchase->status = 2;
                $nftpurchase->update();

                if(Auth::check()){
                    return redirect()->route('sell_nft')->with(['success'=>trans('custom.counter_offer_approve')]);
                }
                else{
                    return redirect()->route('login')->with(['success'=>trans('custom.counter_offer_approve')]);
                }
            }else{
                $counteroffer->status = 4;
                $counteroffer->counter_offer_status = 3;
                $counteroffer->update();
                $nfttype = NftPurchaseHistory::find($counteroffer->nft_purchase_history_id);
                $nfttype->type = 0;
                $nfttype->save();
                if(Auth::check()){
                    return redirect()->route('sell_nft')->with(['success'=>trans('custom.counter_offer_reject')]);
                }
                else{
                    return redirect()->route('login')->with(['success'=>trans('custom.counter_offer_reject')]);
                }
            }
        }
        else{
            if(Auth::check()){
                return redirect()->route('sell_nft')->with(['error'=>trans('custom.counter_offer_aleady')]);
            }
            else{
                return redirect()->route('login')->with(['error'=>trans('custom.counter_offer_aleady')]);
            }
        }       
    }
}
