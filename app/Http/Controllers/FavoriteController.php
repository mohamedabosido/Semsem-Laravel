<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_uid = $request->query('uid');
        $favorites = Favorite::where('uid', '=' , $request_uid)->get();

        $products = [];

        foreach($favorites as $obj) {
            $product = Product::find($obj->pid);
            array_push($products, $product);
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
        $product = Favorite::create([
            'uid' => $request->uid,
            'pid' => $request->pid,
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
        // return Favorite::findOrFail($id);
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
     * @param  Request  $requset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request_uid = $request->query('uid');
        $request_pid = $request->query('pid');
        DB::table('favorites')->where([
            ['uid', '=' , $request_uid],
            ['pid', '=' , $request_pid],
        ])->delete();
        $items = DB::table('favorites')->where('uid', '=' , $request_uid)->get();
            $response = [
                'data' =>$items,
            ];
            return response($response ,200);
    }
}
