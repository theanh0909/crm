<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Registered;
use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\Certificate;

class ImportProfile implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        
        return Registered::create([
            'code'     => $row[0],
            'certificate_number'      => $productType,
            'full_name'  => $row[2],
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

    public function headingRow(): int
    {
        return 1;
    }

}
