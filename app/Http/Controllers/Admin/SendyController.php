<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Hocza\Sendy\Sendy;

class SendyController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('admin.sendy.index', compact('products'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product);
        $transactions = Transaction::where('product_type', $product->product_type)
                                    ->where('status', 1)
                                    ->take(5)
                                    ->get();
        $config = [
            // Sendy installation URL
            'installationUrl' => 'http://sendy.gxd.vn',
            // Default list id
            'listId' => $product->api,
            // The Sendy API Key
            'apiKey' => '6oZ2JkGacExikGWFSy9B',
        ];
        $subscriber = new Sendy($config);
        
        foreach ($transactions as $item) {
            $subscriber->subscribe([
                'name' => $item->customer_name,
                'email' => $item->customer_email
            ]);
        }

        return back()->with('success', 'Gửi Sendy thành công');
    }
}
