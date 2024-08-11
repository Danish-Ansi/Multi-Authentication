<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->passes()){
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
                if(Auth::guard('admin')->user()->role != "admin"){
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'You are not an admin');
                }
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('admin.login')->with('error','invalid email or password');
            }
        }else{
            return redirect()->route('admin.login')->withErrors($validator)->withInput();
        }
    }


    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','User Logout Successfully');
    }
}
