<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Registered;
use App\Models\Customer;

class ToolController extends Controller
{
    public function convertCustomer()
    {
        ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
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

    public function convertCustomerFromRegistered()
    {
        ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
        $registered = Registered::select('customer_email')->get();

        foreach ($registered as $item) {
            if ($item->customer_email != '') {
                $customer = Customer::updateOrCreate(
                    [
                        'email' => $item->customer_email
                    ],[
                        'name' => $item->customer_name,
                        'phone' => $item->customer_phone,
                        'address' => $item->customer_address,
                        'city' => $item->customer_cty
                    ]
                );
                Transaction::where('id', $item->id)->update(['customer_id' => $customer->id]);
            }
        }
    }
}
