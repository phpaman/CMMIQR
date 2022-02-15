<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;             

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request){
    $this->validate($request, [
        'email'           => 'required|max:255|email',
        'password'           => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        if(Auth::user()->role == 'admin'){
        return redirect('admin/dashboard');
        }elseif(Auth::user()->role == 'user'){
        return redirect('user/dashboard');
        }
    } else {
        return redirect()->back();
    }
    }

    public function logout(){
        Auth::logout();
       return redirect('/admin/login');
    }
}
