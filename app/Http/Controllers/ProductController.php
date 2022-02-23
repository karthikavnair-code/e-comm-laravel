<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
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
}
