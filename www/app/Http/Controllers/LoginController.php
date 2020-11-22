<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class LoginController extends Controller
{

    // protected $redirectTo = '/';

    public function username() {
        return 'username';
    }

    public function login() {
        return view('login');
    }


    public function doLogin(Request $request) {
        $input = $request->all();

        $this->validate($request,[
            'username'  => 'required',
            'password'  => 'required',
        ]);


        /*
        if ( ! Users::where('username',$input["username"])->firstOrFail() ) {
            return redirect()->route('login')
                ->withErrors(array('error' => 'خطا در ورود'));
        }
        */


        if ( Auth()->attempt(array( 'username'  => $input['username'], 'password' => $input['password'], 'enabled' => true ),true) ) {
            $user = Auth()->user();
            //$request->session()->start();
            //$request->session()->put('user',');

            return redirect()->route('home')
                ->with(array('data' => $user));

        } else {
            return redirect()->route('login')
                ->withErrors(array('error' => 'خطا در ورود'));

        }

    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

}
