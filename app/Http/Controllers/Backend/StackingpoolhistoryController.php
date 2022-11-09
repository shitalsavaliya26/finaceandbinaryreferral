<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StackingPool;

class StackingpoolhistoryController extends Controller
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
        $stacking_pool_history = StackingPool::with([
            'user_detail' => function ($query) {
                $query->withTrashed();
            },
            'staking_pool_package',
        ]);



        if ($request->username && $request->username != '') {
            $stacking_pool_history = $stacking_pool_history->whereHas(
                'user_detail',
                function ($query) use ($request) {
                    $query->where('username', $request->username);
                }
            );
        }

        if ($request->status && $request->status != '') {
            if ($request->status == 2) {
                $stacking_pool_history = $stacking_pool_history->where(
                    'status',
                    '2'
                );
            } else {
                $stacking_pool_history = $stacking_pool_history->where(
                    'status',
                    '1'
                );
            }
        }

        // if ($request->start && $request->end) {
        //     $start_date = date('Y-m-d', strtotime($request->start));
        //     $end_date = date('Y-m-d', strtotime($request->end));
        //     $stacking_pool_history = $stacking_pool_history
        //         ->whereRaw(
        //             'DATE_FORMAT(created_at,"%Y-%m-%d") >= "' .
        //                 $start_date .
        //                 '"'
        //         )
        //         ->whereRaw(
        //             'DATE_FORMAT(created_at,"%Y-%m-%d") <= "' . $end_date . '"'
        //         );
        // }

        $data = $request->all();
        $total_amount = $stacking_pool_history->sum('amount');

        $stacking_pool_history = $stacking_pool_history
            ->orderBy('id', 'desc')
            ->paginate($this->limit)
            ->appends($data);
        return view(
            'backend.stacking_pool_history.index',
            compact('stacking_pool_history', 'data', 'total_amount')
        );
    }




    //Nft Wallets Payment History export
    public function exportData(Request $request)
    {
        try {
           
            $stacking_pool_history = StackingPool::with([
                'user_detail' => function ($query) {
                    $query->withTrashed();
                },
                'staking_pool_package',
            ]);
    
    
    
            if ($request->username && $request->username != '') {
                $stacking_pool_history = $stacking_pool_history->whereHas(
                    'user_detail',
                    function ($query) use ($request) {
                        $query->where('username', $request->username);
                    }
                );
            }
    
            if ($request->status && $request->status != '') {
                if ($request->status == 2) {
                    $stacking_pool_history = $stacking_pool_history->where(
                        'status',
                        '2'
                    );
                } else {
                    $stacking_pool_history = $stacking_pool_history->where(
                        'status',
                        '1'
                    );
                }
            }
    
            // if ($request->start && $request->end) {
            //     $start_date = date('Y-m-d', strtotime($request->start));
            //     $end_date = date('Y-m-d', strtotime($request->end));
            //     $stacking_pool_history = $stacking_pool_history
            //         ->whereRaw(
            //             'DATE_FORMAT(created_at,"%Y-%m-%d") >= "' .
            //                 $start_date .
            //                 '"'
            //         )
            //         ->whereRaw(
            //             'DATE_FORMAT(created_at,"%Y-%m-%d") <= "' . $end_date . '"'
            //         );
            // }
        
            $stacking_pool_history = $stacking_pool_history
                ->orderBy('id', 'desc')
                ->get();


           if(count( $stacking_pool_history ) > 0){
               return ((new \Rap2hpoutre\FastExcel\FastExcel($stacking_pool_history))->download('sph-' . time() . '.xlsx', function ($stacking_pool_history) {
                   return [
                        'Username' => $stacking_pool_history->user_detail->username,
                        'Package' => $stacking_pool_history->staking_pool_package->name,
                        'Amount' => number_format($stacking_pool_history->amount,2),
                        'Period' => $stacking_pool_history->stacking_period ?? '',
                        'Start Date' => $stacking_pool_history->start_date ?? '',
                        'End Date' => $stacking_pool_history->end_date ?? '',
                        'Status' =>  ($stacking_pool_history->status == 2) ? ("Closed") : ("Active"),
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
