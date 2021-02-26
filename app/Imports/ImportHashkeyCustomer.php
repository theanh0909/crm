<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Registered;
use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportHashkeyCustomer implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        $row = array_values($row);
        //dd($row);
        $user = User::where('email', $row[7])->first();

        $user_support_id = ($user) ? $user->id : '';

        $checkExists = Registered::where('hardware_id', 'KHOACUNG')->where('license_original', $row[2])->first();
        if($checkExists) {

            $checkExists->customer_name     = $row[0];
            $checkExists->customer_phone    = $row[3];
            $checkExists->customer_email    = $row[4];
            $checkExists->customer_address  = $row[5];
            $checkExists->customer_cty      = $row[6];
            $checkExists->user_support_id   = $user_support_id;
            $checkExists->price             = $row[8];
            $checkExists->discount          = $row[9];
            $checkExists->qty               = $row[10];

            return $checkExists->save();

        } else {
            $product = Product::where('name', $row[1])->first();
            $productType = ($product) ? $product->product_type : '';

            return Registered::create([
                'customer_name'     => $row[0],
                'product_type'      => $productType,
                'license_original'  => $row[2],
                'customer_phone'    => $row[3],
                'customer_email'    => $row[4],
                'customer_address'  => $row[5],
                'customer_cty'      => $row[6],
                'user_support_id'   => $user_support_id,
                'hardware_id'       => 'KHOACUNG',
                'price'             => $row[8],
                'discount'          => $row[9],
                'qty'               => $row[10],
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

}
