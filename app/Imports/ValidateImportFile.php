<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;

class ValidateImportFile implements ToModel, WithHeadingRow
{
  /**
   * @var errors
   */
  public $errors = [];

  /**
   * @var isValidFile
   */
  public $isValidFile = false;

  /**
   * ValidateCsvFile constructor.
   * @param StoreEntity $store
   */
  public function __construct()
  {
      //
  }

  public function model(array $rows)
  {
      $errors = [];

      if (count($rows) > 1) {
          foreach ($rows as $key => $row) {
              $row[] = $row;
              try {
                $validator = Validator::make($row, [
                    '0' => [
                        'required',
                    ]
                ]);
                if ($validator->fails()) {
                    $errors[$key] = $validator;
                }
              } catch (\Throwable $th) {
                  dd($th->getMessage());
              }
                
          }
          $this->errors = $errors;
          dd($this->errors);
          $this->isValidFile = true;
      }
  }

  public function headingRow(): int
  {
      return 1;
  }
}