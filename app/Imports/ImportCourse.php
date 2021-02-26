<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Registered;
use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportCourse implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        $row = array_values($row);
        $user = User::where('email', $row[6])->first();

        $user_support_id = ($user) ? $user->id : '';

        $product = Product::where('name', $row[1])->first();
        $productType = ($product) ? $product->product_type : '';

        return Registered::create([
            'customer_name'     => $row[0],
            'product_type'      => $productType,
            'customer_phone'    => $row[2],
            'customer_email'    => $row[3],
            'customer_address'  => $row[4],
            'customer_cty'      => $row[5],
            'user_support_id'   => $user_support_id,
            'hardware_id'       => 'KHOAHOC',
            'price'             => $row[7],
            'discount'          => $row[8],
            'qty'               => $row[9],
            'option'            => $row[10]
        ]);

    }

    public function headingRow(): int
    {
        return 1;
    }

}
