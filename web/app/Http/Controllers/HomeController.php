<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home() {
        return view('home');
    }




}
