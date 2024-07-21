<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Redirect;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function prosesLogin(Request $request)
    {
        if (Auth::attempt(['username'=>$request->username,'password'=>$request->password]))
        {
            if (Auth::User()->level == "Admin")
            {
                return \Redirect::to('/admin/home');
            }
            elseif (Auth::User()->level == "Pimpinan")
            {
                return \Redirect::to('/pimpinan/home');
            }
        }
        else
        {
            \Session::flash('msg_login','Username Atau Password Salah!');
            return \Redirect::to('/');
        }
    }
    public function logout(){
        Auth::logout();
      return \Redirect::to('/');
    }
}
