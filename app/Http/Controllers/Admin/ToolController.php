<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Customer;

class ToolController extends Controller
{
    public function convertCustomer()
    {
        $transactions = Transaction::all();

        foreach ($transactions as $item) {
            if ($item->customer_email != '') {
                $customer = Customer::updateOrCreate(
                    [
                        'email' => $item->customer_email
                    ],[
                        'name' => $item->customer_name,
                        'phone' => $item->customer_phone,
                        'address' => $item->customer_address,
                        'birthday' => $item->customer_birthday,
                        'company' => $item->company,
                        'city' => $item->customer_cty,
                        'school' => $item->school,
                        'nation' => $item->nation,
                        'id_card' => $item->id_card,
                        'date_card' => $item->date_card
                    ]
                );
                Transaction::where('id', $item->id)->update(['customer_id' => $customer->id]);
            }
        }
    }
}
