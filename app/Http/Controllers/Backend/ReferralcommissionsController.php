<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReferralCommission;
use App\Models\StackingPoolPackage;
use App\Models\User;

class ReferralcommissionsController extends Controller
{

    public function __construct(Request $request)
    {
        $this->limit = $request->limit ? $request->limit : 50;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $referral_commission = ReferralCommission::with([
            'user_detail' => function ($query) {
                $query->withTrashed();
            },
            'from_user_detail' => function ($query) {
                $query->withTrashed();
            },
            'staking_pool' => function ($query) {
                $query->with('staking_pool_package');
            },
        ]);

       
        if(!empty($request->get('pool'))){

            // $referral_commission = $referral_commission->where(
            //     'stacking_pool_id',$request->get('pool'));
                $referral_commission = $referral_commission->whereHas('staking_pool',function($query) use ($request){
                    $query->where('stacking_pool_package_id',$request->get('pool'));
                });

            $name = StackingPoolPackage::find($request->get('pool'));
        }

    

        if(!empty($request->get('user'))){
            $referral_commission = $referral_commission->where(
                'user_id',$request->get('user'));
            $name = User::find($request->get('user'));
        }

        $total_amount = $referral_commission->sum('amount');
        $referral_commission = $referral_commission
        ->orderBy('id', 'desc')
        ->paginate($this->limit);

        // $referral_commission = $referral_commission
        // ->orderBy('id', 'desc')
        // ->get();

        // dd( $referral_commission);
        return view(
            'backend.referral_commission.index',
            compact('referral_commission','total_amount','name')
        );
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
