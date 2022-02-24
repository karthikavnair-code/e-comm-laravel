<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;

use Illuminate\Support\Facades\DB;
use Session;

class ProductController extends Controller
{
    function index(){
        $data = Product::all();
        return view('products', ['products'=>$data]);
    }

    function detail($id){
        $data = Product::find($id);
        return view('detail', ['product'=>$data]);
    }

    function addToCart(Request $request){
        if($request->session()->has('user')){
            $data = new Cart;
            $data->user_id = $request->session()->get('user')['id'];
            $data->product_id = $request->productId;
            $data->save();
            return redirect('product');
        } else{
            return redirect('login');
        }
    }

    static function totalCartItem(){
        $userId = Session::get('user')['id'];
        return Cart::where('user_id', $userId)->count();
    }

    function cartlist(){
        $userId = Session::get('user')['id'];
        //QUERY BUILDER METHOD
        // return DB::table('carts')
        // ->join('products', 'carts.product_id', '=', 'products.id')
        // ->where('carts.user_id', $userId)->get();

        //ELOQUENT METHOD, (products)-table name inside the DB.
        $data = Cart::join('products', 'carts.product_id', '=', 'products.id')
        ->where('carts.user_id', $userId)
        ->select('products.*', 'carts.id as cart_id')  
        ->get();     

        return view('cartList', ['products'=>$data]);
    }

    function removeCartItem($id){
        Cart::destroy($id);
        return redirect('cartlist');
    }

    function orderNow(){
        $userId = Session::get('user')['id'];
        $total = Cart::join('products', 'carts.product_id', '=', 'products.id')
        ->where('carts.user_id', $userId)
        ->sum('products.price');

        return view('orderNow', ['total'=>$total]);
    }

    function placeOrder(Request $req){
        $userId = Session::get('user')['id'];
        $allCart = Cart::where('user_id',$userId)->get();
        foreach($allCart as $item){
            $data = new Order;
            $data->product_id = $item['product_id'];
            $data->user_id = $item['user_id'];
            $data->status = "Pending";
            $data->payment_method = $req->payment;
            $data->payment_status = "Pending";
            $data->address = $req->address;
            $data->save();
            Cart::where('user_id',$userId)->delete();
        }
        return redirect('product');
    }

    function myorders(){
        $userId = Session::get('user')['id'];
        $data = Order::join('products', 'products.id', '=', 'orders.product_id')
                ->where('orders.user_id', $userId)
                ->get();
        return view('myOrders', ['orders'=>$data]);
    }
}
