<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\Product;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index()
    {
        $products = Product::with('has_email')->paginate(10);
        return view('admin.email.index', compact('products'));
    }

    public function edit(Request $request, $productID)
    {
        $product = Product::where('id', $productID)->first();
        $email   = $product->has_email;

        return view('admin.email.edit', compact('email', 'product'));
    }

    public function update(Request $request, $productID)
    {
        $inputs = $request->only(['subject', 'content', 'subject_trial', 'content_trial']);
        $product = Product::where('id', $productID)->first();
        $email   = $product->has_email;
        if($email) {
            $email->subject         = $inputs['subject'];
            $email->content         = $inputs['content'];
            $email->subject_trial   = $inputs['subject_trial'];
            $email->content_trial   = $inputs['content_trial'];
            $email->product_type    = $product->product_type;
            $email->save();
        } else {
            $inputs['product_type'] = $product->product_type;
            Email::create($inputs);
        }

        return redirect()->route('admin.email.index');
    }
}
