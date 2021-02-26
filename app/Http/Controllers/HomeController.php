<?php

namespace App\Http\Controllers;

use App\Services\Captcha\SimpleCaptcha;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function createCaptcha()
    {
        $captcha = new SimpleCaptcha();

        dd($captcha->CreateImage());
        echo $captcha->CreateImage();
    }
}
