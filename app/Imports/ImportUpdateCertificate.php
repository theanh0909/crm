<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Registered;
use App\Models\Transaction;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB as FacadesDB;

class ImportUpdateCertificate implements ToModel, WithHeadingRow
{
    use Importable;

    public function __construct($name_upload)
    {
        $this->name_upload = $name_upload;
    }

    public function model(array $row)
    {
        $row = array_values($row);
        $check = Transaction::where('name_upload', $this->name_upload)->count();
    /**
     * Kiểm tra có đợt upload đó ms thực hiện
     */
        if ($check > 0) {
            try {
                if ($row[25] != '') {
                    $status_exam = 1;
                } else {
                    $status_exam = 0;
                }
                FacadesDB::beginTransaction();
                    Transaction::updateOrCreate(
                        [
                            'name_upload' => $this->name_upload,
                            'customer_email' => trim($row[7]),
                            'customer_phone' => trim($row[6]),
                            'id_card' => trim($row[5]),
                        ],
                        [
                            'user_request_id' => auth()->user()->id,
                            'product_type' => trim($this->getProductType($row[9], $row[11])),
                            'customer_account' => $row[0],
                            'customer_name' => $row[2],
                            'customer_birthday' => $this->formatDate($row[3]),
                            'customer_address' => $row[4],
                            'qualification' => $row[8],
                            'type_exam' => trim($row[9]),
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
                            'customer_cty' => $row[23],
                            'retest' => ($row[24] == '') ? 0 : $row[24],
                            'date_exam' => $this->formatDate($row[25]),
                            'note' => $row[26],
                            'status_exam' => $status_exam,
                            'customer_type' => 3
                        ]
                    );
        
                    $sale = Sale::updateOrCreate(
                        [
                            'customer_phone' => trim($row[6]),
                            'customer_email' => trim($row[7]),
                            'name_upload' => $this->name_upload
                        ],
                        [
                            'user_id' => auth()->user()->id,
                            'customer_name' => $row[2],
                            'customer_address' => $row[4],
                            'customer_city' => $row[23],
                            'total' => $row[19],
                            'prepaid' => $row[20],
                            'status_prepaid' => ($row[19] > $row[20]) ? 1 : 0,
                            'note' => $row[26],
                        ]
                    );
                    SaleDetail::updateOrCreate(
                        [
                            'sale_id' => $sale->id,
                        ],
                        [
                            'product' => trim($this->getProductType($row[9], $row[11])),
                            'product_type' => 3,
                            'qty' => 1,
                            'price' => $row[19],
                            'discount' => $row[21],
                        ]
                    ); 
                FacadesDB::commit();
            } catch (\Throwable $th) {
                FacadesDB::rollback();
                dd($th->getMessage());
            }
        }
    }

    public function formatDate($date)
    {
        if ($date != '') {
            $date = str_replace('/', '-', trim($date));

            return date('Y-m-d', strtotime($date));
        } else {
            return NULL;
        }
    }

    public function getProductType($class, $product)
    {
        $dem = substr_count($class, ';') + 1;

        return strtolower($product) . $dem;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
