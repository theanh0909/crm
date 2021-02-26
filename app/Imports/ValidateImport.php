<?php

namespace App\Imports;

use App\TransactionWait;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Validator;

class ValidateImport implements WithHeadingRow, ToCollection
{
    use Importable;

    public $errors = []; 

    public $isValidFile = false;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function collection(Collection $rows)
    {
        $errors = [];
        $rows = $rows->toArray();
        
        foreach ($rows as $key => $rowItem) {
            $rowItem = $this->comvertKeyToString($rowItem);

            $validator = Validator::make($rowItem, 
                [
                    '2gxd' => 'required',
                    '3gxd' => 'required',
                    '4gxd' => 'required',
                    '5gxd' => 'required',
                    '6gxd' => 'required',
                    '7gxd' => 'required',
                    '8gxd' => 'required',
                    '9gxd' => 'required',
                    '10gxd' => 'required',
                    '11gxd' => 'required',
                    '12gxd' => 'required',
                    '13gxd' => 'required',
                    '14gxd' => 'required',
                    '15gxd' => 'required',
                    '16gxd' => 'required',
                    '17gxd' => 'required',
                    '18gxd' => 'required',
                    '19gxd' => 'required',
                    '23gxd' => 'required',
                ],
                [
                    '2gxd.required' => "Cần điền họ tên ở dòng " . ($key+1),
                    '3gxd.required' => "Cần điền ngày sinh ở dòng " . ($key+1),
                    '4gxd.required' => "Cần địa chỉ thường chú ở dòng " . ($key+1),
                    '5gxd.required' => "Cần CMND ở dòng " . ($key+1),
                    '6gxd.required' => "Cần điền SĐT ở dòng " . ($key+1),
                    '7gxd.required' => "Cần điền Email ở dòng " . ($key+1),
                    '8gxd.required' => "Cần điền trình độ chuyên môn ở " . ($key+1),
                    '9gxd.required' => "Cần điền lĩnh vực sát hạch " . ($key+1),
                    '10gxd.required' => "Cần điền hạng sát hạch ở dòng " . ($key+1),
                    '11gxd.required' => "Cần điền mã tỉnh ở dòng " . ($key+1),
                    '12gxd.required' => "Cần điền số năm kinh nghiệm ở dòng " . ($key+1),
                    '13gxd.required' => "Cần điền đơn vị công tác ở dòng " . ($key+1),
                    '14gxd.required' => "Cần điền ngày cấp CMND ở dòng " . ($key+1),
                    '15gxd.required' => "Cần điền nơi cấp ở dòng " . ($key+1),
                    '16gxd.required' => "Cần điền quốc tịch ở dòng " . ($key+1),
                    '17gxd.required' => "Cần điền hệ đào tạo ở dòng " . ($key+1),
                    '18gxd.required' => "Cần điền cơ sở đào tạo ở dòng " . ($key+1),
                    '19gxd.required' => "Cần điền giá ở dòng " . ($key+1),
                    '23gxd.required' => "Cần điền thành phố dòng " . ($key+1),
                ]
            );
        
            if ($validator->fails()) {
                $errors[$key+1] = $validator->messages();
            }
        }
        $this->errors = $errors;
        $this->isValidFile = true;
    }

    public function comvertKeyToString($rows)
    {
        $list = [];
        $stt = 0;

        foreach($rows as $rowItem) {
            $list[$stt . 'gxd'] = $rowItem;
            $stt++;
        }

        return $list;
    }

    // public function model(array $row)
    // {
    //     $row = array_values($row);
    //     dd($row);
    //     return new TransactionWait([
    //         //
    //     ]);
    // }

    public function headingRow(): int
    {
        return 1;
    }
}
