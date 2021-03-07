<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocController extends Controller
{
    public function slogan()
    {
        return view('admin.docs.slogan');
    }

    public function vision()
    {
        return view('admin.docs.vision');
    }

    public function mision()
    {
        return view('admin.docs.mission');
    }

    public function corporate_culture()
    {
        return view('admin.docs.corporate-culture');
    }

    public function core_values()
    {
        return view('admin.docs.core-values');
    }
}
