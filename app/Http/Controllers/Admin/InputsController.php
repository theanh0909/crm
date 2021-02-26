<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputsController extends Controller
{
    public function inputForm()
    {
        return view('admin.inputs.create');
    }
}
