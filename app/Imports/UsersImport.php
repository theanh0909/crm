<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use App\User;

class UsersImport implements ToModel, ShouldQueue, WithChunkReading, WithStartRow
{
    use Importable;

    /**
     * @var errors
     */
    private $errors;

    /**
     * @var row
     */
    private $row = 1;

    /**
     * UsersImport constructor.
     * @param StoreEntity $store
     */
    public function __construct($errors = [])
    {
        $this->errors = $errors;
    }

    public function model(array $row)
    {
        // if (array_key_exists(++$this->row, $this->errors)) {
        //     return null;
        // }

        $validator = Validator::make($row, [
            '0' => [
                'required',
                'max:255',
            ],
        ]);

        if ($validator->fails()) {
            dd(1);
            return null;
        }
        dd(2);

        DB::beginTransaction();
        try {
            User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => $row[2],
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug($e);
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function startRow(): int
    {
        return 2;
    }
}
