<?php

namespace App\Imports;

use App\TransactionWait;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Validator;

class TestImport implements WithHeadingRow, ToCollection
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function collection(Collection $rows)
    {
        $rows = $rows->toArray();
        
        foreach ($rows as $rowItem) {
            $rowItem = array_values($rowItem);

            $validator = Validator::make($rowItem, [
                $rowItem[1] => 'required',
            ]);
        
            if ($validator->fails()) {
                dd(1);
            }
            dd(2);
        }
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
