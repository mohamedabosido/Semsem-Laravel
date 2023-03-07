<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Contains;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $request_uid = $request->query('uid');
        $orders = Order::where('uid', '=' , $request_uid)->get();

        $categoires = [];

        foreach($orders as $obj) {
            $product = Product::find($obj->pid);
            $category = Category::find($product->cid);
                if(!in_array($category,$categoires)){
                    array_push($categoires, $category);
                }
        }

        return response()->json($categoires);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'uid' => $request->uid,
            'pid' => $request->pid,
            'count' =>$request->count,
        ]);
        $response = [
            'order' =>$order,
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
        return Order::findOrFail($id);
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
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request_uid = $request->query('uid');
        $request_pid = $request->query('pid');
        DB::table('orders')->where([
            ['uid', '=' , $request_uid],
            ['pid', '=' , $request_pid],
        ])->delete();
        $orders = DB::table('orders')->where('uid', '=' , $request_uid)->paginate();
            $response = [
                'data' =>$orders,
            ];
            return response($response ,200);
    }

        /**
     * Return the Top Selling Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function top()
    { 
        $top_sales=DB::table('products')
        ->join('orders','products.id' ,'=' ,'pid')
        ->select('products.id', DB::raw('sum(count) as total'))
        ->groupBy('products.id')
        ->orderBy('total','desc')
        ->take(10)
        ->get();
        $products = [];

        foreach($top_sales as $obj) {
            $product = Product::find($obj->id);
            array_push($products, $product);
        }

        return response()->json($products);
    }
}
