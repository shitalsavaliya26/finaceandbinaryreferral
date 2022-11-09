<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NftPurchaseHistory;

class NftpurchaseController extends Controller
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
        $nft_purchase_history = NftPurchaseHistory::with([
            'user_detail' => function ($query) {
                $query->withTrashed();
            },
            'nftproduct',
        ]);

        if ($request->username && $request->username != '') {
            $nft_purchase_history = $nft_purchase_history->whereHas(
                'user_detail',
                function ($query) use ($request) {
                    $query->where('username', $request->username);
                }
            );
        }

        // if ($request->status && $request->status != '') {
        //     if ($request->status == 1) {
        //         $nft_purchase_history = $nft_purchase_history->where(
        //             'status',
        //             '3'
        //         );
        //     } elseif ($request->status == 2) {
        //         $nft_purchase_history = $nft_purchase_history->where(
        //             'status',
        //             '2'
        //         );
        //     } elseif ($request->status == 3) {
        //         $nft_purchase_history = $nft_purchase_history->where(
        //             'status',
        //             '1'
        //         );
        //     } else {
        //         $nft_purchase_history = $nft_purchase_history->where(
        //             'status',
        //             '0'
        //         );
        //     }
        // }

        if ($request->status && $request->status != '') {
            if ($request->status == 1) {
                $nft_purchase_history = $nft_purchase_history->where(
                    'status',
                    '1'
                );
            } elseif ($request->status == 2) {
                $nft_purchase_history = $nft_purchase_history->where(
                    'status',
                    '2'
                );
            } elseif ($request->status == 3) {
                $nft_purchase_history = $nft_purchase_history->where(
                    'status',
                    '3'
                );
            } else {
                $nft_purchase_history = $nft_purchase_history->where(
                    'status',
                    '0'
                );
            }
        }

        if ($request->start && $request->end) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
            $nft_purchase_history = $nft_purchase_history
                ->whereRaw(
                    'DATE_FORMAT(created_at,"%Y-%m-%d") >= "' .
                        $start_date .
                        '"'
                )
                ->whereRaw(
                    'DATE_FORMAT(created_at,"%Y-%m-%d") <= "' . $end_date . '"'
                );
        }

        $data = $request->all();
        $total_amount = $nft_purchase_history->sum('amount');

        $nft_purchase_history = $nft_purchase_history
            ->orderBy('id', 'desc')
            ->paginate($this->limit)
            ->appends($data);
        return view(
            'backend.nft_purchase_history.index',
            compact('nft_purchase_history', 'data', 'total_amount')
        );
    }

    public function exportData(Request $request)
    {
        try {
            $nft_purchase_history = NftPurchaseHistory::with([
                'user_detail' => function ($query) {
                    $query->withTrashed();
                },
                'nftproduct',
            ]);

            if ($request->username && $request->username != '') {
                $nft_purchase_history = $nft_purchase_history->whereHas(
                    'user_detail',
                    function ($query) use ($request) {
                        $query->where('username', $request->username);
                    }
                );
            }

            // if ($request->status && $request->status != '') {
            //     if ($request->status == 1) {
            //         $nft_purchase_history = $nft_purchase_history->where(
            //             'status',
            //             '3'
            //         );
            //     } elseif ($request->status == 2) {
            //         $nft_purchase_history = $nft_purchase_history->where(
            //             'status',
            //             '2'
            //         );
            //     } elseif ($request->status == 3) {
            //         $nft_purchase_history = $nft_purchase_history->where(
            //             'status',
            //             '1'
            //         );
            //     } else {
            //         $nft_purchase_history = $nft_purchase_history->where(
            //             'status',
            //             '0'
            //         );
            //     }
            // }

            if ($request->status && $request->status != '') {
                if ($request->status == 1) {
                    $nft_purchase_history = $nft_purchase_history->where(
                        'status',
                        '1'
                    );
                } elseif ($request->status == 2) {
                    $nft_purchase_history = $nft_purchase_history->where(
                        'status',
                        '2'
                    );
                } elseif ($request->status == 3) {
                    $nft_purchase_history = $nft_purchase_history->where(
                        'status',
                        '3'
                    );
                } else {
                    $nft_purchase_history = $nft_purchase_history->where(
                        'status',
                        '0'
                    );
                }
            }
    
            if ($request->start && $request->end) {
                $start_date = date('Y-m-d', strtotime($request->start));
                $end_date = date('Y-m-d', strtotime($request->end));
                $nft_purchase_history = $nft_purchase_history
                    ->whereRaw(
                        'DATE_FORMAT(created_at,"%Y-%m-%d") >= "' .
                            $start_date .
                            '"'
                    )
                    ->whereRaw(
                        'DATE_FORMAT(created_at,"%Y-%m-%d") <= "' .
                            $end_date .
                            '"'
                    );
            }

            $data = $request->all();
            $total_amount = $nft_purchase_history->sum('amount');

            $nft_purchase_history = $nft_purchase_history
                ->orderBy('id', 'desc')
                ->get();

            if (count($nft_purchase_history) > 0) {
                return (new \Rap2hpoutre\FastExcel\FastExcel(
                    $nft_purchase_history
                ))->download('Nph-' . time() . '.xlsx', function (
                    $nft_purchase_history
                ) {
                    return [
                        'Username' =>
                            $nft_purchase_history->user_detail->username,
                        'Product' => $nft_purchase_history->nftproduct->name,
                        'Amount' => number_format(
                            $nft_purchase_history->amount,
                            2
                        ),
                        'Order ID' => $nft_purchase_history->order_id ?? '',
                        'Purchase Date' => $nft_purchase_history->purchase_date
                            ? date_format(
                                $nft_purchase_history->purchase_date,
                                'Y-m-d'
                            )
                            : date_format(
                                $nft_purchase_history->created_at,
                                'Y-m-d'
                            ),
                        'Sell Date' => $nft_purchase_history->sell_date
                            ? date_format(
                                $nft_purchase_history->sell_date,
                                'Y-m-d'
                            )
                            : date_format(
                                $nft_purchase_history->created_at,
                                'Y-m-d'
                            ),
                        'Status' => ($nft_purchase_history->status == '1') ? ('Purchased') : (($nft_purchase_history->status == '2') ? ('On Sale') : (($nft_purchase_history->status == '3') ? ('Sold') : ('-'))),
                    ];
                });
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'No Recored Found....');
            }
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
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
