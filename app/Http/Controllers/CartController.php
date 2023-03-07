<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $request_uid = $request->query('uid');
        $carts = Cart::where('uid', '=' , $request_uid)->get();

        $products = [];

        foreach($carts as $obj) {
            $product = Product::find($obj->pid);
            $count = $obj->count;
            array_push($products, ['product'=>$product,'count'=>$count]);
        }

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Cart::create([
            'uid' => $request->uid,
            'pid' => $request->pid,
            'count' =>$request->count,
        ]);
        $response = [
            'product' =>$product,
        ];
        return response($response ,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cart::findOrFail($id);
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request_uid = $request->query('uid');
        $request_pid = $request->query('pid');
        DB::table('carts')->where([
            ['uid', '=' , $request_uid],
            ['pid', '=' , $request_pid],
        ])->delete();
        $carts = DB::table('carts')->where('uid', '=' , $request_uid)->paginate();
            $response = [
                'data' =>$carts,
            ];
            return response($response ,200);
    }
}
