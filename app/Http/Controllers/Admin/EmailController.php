<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\Production\MailService;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        $products = Product::with('has_email')->paginate(10);
        return view('admin.email.index', compact('products'));
    }

    public function formCreate()
    {
        $products = Product::all();

        return view('admin.email.create', compact('products'));
    }

    public function formSend(Request $request)
    {
        $email = !empty($request->email) ? $request->email : '';
        $emailModel = Email::all();
        $products = Product::all();

        return view('admin.email.send', compact('email', 'emailModel', 'products'));
    }

    public function send(Request $request)
    {
        $emails = explode(',', $request->email);
        $customers = Customer::whereIn('email', $emails)->get();
        $mailModel = Email::find($request->mail_id);
        $product = $request->product_type;
        
        foreach ($customers as $customer) {
            $name = $customer->name;
            $customerEmail = $customer->email;
            Mail::send([], [], function($message) use ($mailModel, $name, $customerEmail, $product) {
                $subject = str_replace("[name]", $name, $mailModel->subject);
                $subject = str_replace("[product]", $product, $subject);
                $body    = str_replace("[name]", $name, $mailModel->content);
                $body    = str_replace("[product]", $product, $body);
                $message->to($customerEmail)
                    ->subject($subject)
                    ->setBody($body, 'text/html');
            });
        }
        
        return back()->with('success', 'Gửi thành công');
        //$customer = customer::where('email', $request->)
    }

    public function customer(Request $request)
    {
        $term = $request->term;
        $customers = Customer::where('email', 'like', '%' . $term . '%')->select('email')->take(10)->get();
        $data = [];

        foreach ($customers as $item) {
            $data[] = $item->email;
        }

        return response()->json(['suggestions' => $data]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $product = Product::where('product_type', $data['product_type'])->first();
        Email::create($data);

        return back()->with('success', 'Thêm thành công');
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
