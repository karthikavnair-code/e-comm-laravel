<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

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
}
