<?php

namespace App\Http\Controllers;

use App\Models\VoucherCode;
use Illuminate\Http\Request;

class VoucherCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VoucherCode::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required',
            'percentage'=>'required',
        ]);
        return VoucherCode::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return VoucherCode::findOrFail($id);
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
        return VoucherCode::destroy($id);
    }

    /**
     * search fro a code
     *
     * @param  str  $code
     * @return \Illuminate\Http\Response
     */
    public function search($code)
    {
        return VoucherCode::where('code','=',$code)->get();
    }
}
