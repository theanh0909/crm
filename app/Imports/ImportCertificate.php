<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Registered;
use App\TransactionWait;
use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB as FacadesDB;

class ImportCertificate implements ToModel, WithHeadingRow
{
    use Importable;

    public function __construct($name_upload)
    {
        $this->name_upload = $name_upload;
    }

    public function model(array $row)
    {
        $row = array_values($row);
        
        TransactionWait::create(
            [
                'name_upload' => $this->name_upload,
                'slug' => str_slug($this->name_upload),
                'user_id' => auth()->user()->id,
                'product_type' => trim($this->getProductType($row[9], $row[11])),
                'customer_account' => $row[0],
                'customer_name' => $row[2],
                'customer_birthday' => $this->formatDate($row[3]),
                'customer_address' => $row[4],
                'id_card' => trim($row[5]),
                'customer_phone' => trim($row[6]),
                'customer_email' => $row[7],
                'qualification' => $row[8],
                'type_exam' => trim(rtrim($row[9], ';')),
                'class' => $row[10],
                'exper_num' => (int)$row[12],
                'company' => $row[13],
                'date_card' => $this->formatDate($row[14]),
                'address_card' => $row[15],
                'nation' => $row[16],
                'edu_system' => $row[17],
                'school' => $row[18],
                'price' => $row[19],
                'prepaid' => $row[20],
                'discount' => $row[21],
                'collaborator' => $row[22],
                'customer_city' => $row[23],
                'retest' => $row[24],
                'date_exam' => $this->formatDate($row[25]),
                'note' => $row[26]
            ]
        );
    }

    public function formatDate($date)
    {
        $date = str_replace('/', '-', trim($date));

        return date('Y-m-d', strtotime($date));
    }

    public function getProductType($class, $product)
    {
        $class = rtrim($class, ';');
        $dem = substr_count($class, ';') + 1;

        return strtolower($product) . $dem;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
