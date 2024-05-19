<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function store(Request $request){
     //   dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = new User();
        $data->name = $request->name;
        $data->email  = $request->email ;
        $data->account_type = $request->account_type;
        $data->balance = 0;
        $data->password = Hash::make($request->password);
        $data->save();
        Auth::loginUsingId($data->id,true); // Login and "remember" the given user...
        return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully account created');
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("/")->withSuccess('Oppes! You have entered invalid credentials');
    }
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }
}
