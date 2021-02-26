<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Registered;
use App\Models\Transaction;
use App\Models\License;
use App\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $inputs = $request->all();
        
        return redirect()->route('admin.all-search', ['query' => $inputs['query']]);

        // if ($inputs['product'] == Product::TYPE_SOFWTWARE) {
        //     return redirect()->route('admin.customer.index', ['query' => $inputs['query']]);
        // } else if ($inputs['product'] == Product::TYPE_HARDWARE) {
        //     return redirect()->route('admin.customer.listHashKeyCustomer', ['query' => $inputs['query']]);
        // } else if ($inputs['product'] == Product::TYPE_COURSE) {
        //     return redirect()->route('admin.course.index', ['query' => $inputs['query']]);
        // } else if ($inputs['product'] == Product::TYPE_CERTIFICATE) {
        //     return redirect()->route('admin.course.certificate', ['query' => $inputs['query']]);
        // } else if ($inputs['product'] == Product::TYPE_ALL) {
        //     return redirect()->route('admin.all-search', ['query' => $inputs['query']]);
        // }
    }

    public function allSearch(Request $request)
    {
        $users = User::all();
        $key = $request->get('query');
        //Tìm những người đã kích hoạt
        $customers = Registered::where('customer_name', 'like', '%' . $key . '%')
                               ->orWhere('customer_phone', 'like', '%' . $key . '%')
                               ->orWhere('customer_email', 'like', '%' . $key . '%')
                               ->orWhere('license_original', 'like', '%' . $key . '%')
                               ->latest()
                               ->paginate(20);
        //Tìm những người chưa kích hoạt
        $transactions = Transaction::where('customer_name', 'like', '%' . $key . '%')
                                ->orWhere('customer_phone', 'like', '%' . $key . '%')
                                ->orWhere('customer_email', 'like', '%' . $key . '%')
                                ->latest()
                                ->paginate(20);

        // Tìm kiếm key gửi chưa kích Hoạt
        $licenses = License::where('license_key', 'like', $key . '%')
                            ->orWhere('email_customer', 'like', $key . '%')
                            ->with(['product', 'customer'])
                            ->paginate(20);
        $pageAlias = 'emailsended';

        return view('admin.searchs.result', ['pageAlias' => $pageAlias, 'licenses' => $licenses, 'users' => $users, 'customers' => $customers, 'query' => $key, 'transactions' => $transactions]);
        // $customersUpdate = License::where('license_key', $key)->get();
        
    }
}
