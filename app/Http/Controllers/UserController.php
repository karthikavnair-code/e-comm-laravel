<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    function login(Request $request){
        $data = User::where(['email'=>$request->email])->first();
        if($data && Hash::check($request->password, $data->password)){
            $request->Session()->put('user',$data);
            return redirect('product');
        } else {
            return "Username or Password not match!";
        }

    }

    function register(Request $req){
        $data = new User;
        $data->name = $req->name;
        $data->email = $req->email;
        $data->password = Hash::make($req->password);
        $data->save();
        return redirect('login');
    }
}
