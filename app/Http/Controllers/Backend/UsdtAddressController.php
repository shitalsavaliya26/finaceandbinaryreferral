<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsdtAddress;

class UsdtAddressController extends Controller
{
    public function __construct(Request $request)
    {
        $this->limit = $request->limit ? $request->limit : 10;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $addresses = UsdtAddress::orderBy('id', 'asc')->paginate($this->limit);
        return view('backend.usdt_address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.usdt_address.create');
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
        /* validation start */
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'value' => 'required|unique:usdt_addresses',
                'image' => 'mimes:jpeg,jpg,png',
            ],
            [
                'value.required' => 'The USDT Address field is required.',
                'value.unique' => 'USDT Address already exists.',
            ]
        );
        /* validation end */
        try {
            $usdt_address = new UsdtAddress();
            $usdt_address->name = $request->name;
            $usdt_address->value = $request->value;
            $usdt_address->status = $request->status;

            if ($request->hasFile('image')) {
                $path = 'uploads/qr_image';
                if (!\File::isDirectory(public_path('uploads/qr_image'))) {
                    \File::makeDirectory(
                        public_path('uploads/qr_image'),
                        $mode = 0755,
                        $recursive = true
                    );
                }
                $file_name =
                    time() .
                    '_qr_image.' .
                    $request->image->getClientOriginalExtension();
                $image = $request->image->move(
                    public_path('uploads/qr_image'),
                    $file_name
                );
                $usdt_address->image = $file_name;

                // $original_extension = $request->file('image')->getClientOriginalExtension();
                // $file_name = time().'image.'.$original_extension;
                // $image= $request->image->storeAs('qr_image',$file_name);
                // $usdt_address->image = $file_name;
            }
            $usdt_address->save();
            return redirect()
                ->route('usdt_address.index')
                ->with(['success' => 'UsdtAddress created successfully']);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with(['error' => $e->getMessage()]);
        }
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
        $usdt_address = UsdtAddress::find($id);
        return view('backend.usdt_address.edit', compact('usdt_address'));
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
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'value' => 'required|unique:usdt_addresses,value,' . $id,
                'image' => 'mimes:jpeg,jpg,png',
            ],
            [
                'value.required' => 'The USDT Address field is required.',
                'value.unique' => 'USDT Address already exists.',
            ]
        );
        /* validation end */
        try {
            $usdt_address = UsdtAddress::find($id);
            $usdt_address->name = $request->name;
            $usdt_address->value = $request->value;
            $usdt_address->status = $request->status;

            if ($request->hasFile('image')) {
                $path = 'uploads/qr_image';
                if (!\File::isDirectory(public_path('uploads/qr_image'))) {
                    \File::makeDirectory(
                        public_path('uploads/qr_image'),
                        $mode = 0755,
                        $recursive = true
                    );
                }
                $file_name =
                    time() .
                    '_qr_image.' .
                    $request->image->getClientOriginalExtension();
                $image = $request->image->move(
                    public_path('uploads/qr_image'),
                    $file_name
                );

                // $original_extension = $request->file('image')->getClientOriginalExtension();
                // $file_name = time().'image.'.$original_extension;
                // $image= $request->image->storeAs('qr_image',$file_name);
                // $path = ('uploads/qr_image');
                $imagename = $usdt_address->image;

                if(!empty($usdt_address->image)){
                    if (
                        file_exists(public_path($path) . '/' . basename($imagename))
                    ) {
                        unlink(public_path($path) . '/' . basename($imagename));
                    }
                }
                $usdt_address->image = $file_name;
            }
            $usdt_address->save();
            return redirect()
                ->route('usdt_address.index')
                ->with(['success' => 'Usdt Address Update successfully']);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with(['error' => $e->getMessage()]);
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
        try {
            $usdt_address = UsdtAddress::find($id);
            $imagename = $usdt_address->image;
            $path = 'uploads/qr_image';

            if(!empty($usdt_address->image)){
                if (file_exists(public_path($path) . '/' . basename($imagename))) {
                    unlink(public_path($path) . '/' . basename($imagename));
                }
            }
            if (!$usdt_address) {
                return redirect()
                    ->back()
                    ->with(['error' => 'UsdtAddress not Found']);
            }

            $usdt_address->delete();
            return redirect()
                ->route('usdt_address.index')
                ->with(['success' => 'UsdtAddress delete sucessfully.']);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with(['error' => $e->getMessage()]);
        }
    }
}
