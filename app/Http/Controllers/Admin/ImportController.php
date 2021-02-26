<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\ImportProfile;
use App\Exports\ExportExam;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TestImport;
use App\Imports\ValidateImport;
use App\Imports\ImportCertificate;
use Validator;
use App\TransactionWait;

class ImportController extends Controller
{
    public function importForm()
    {
        return view('admin.imports.index');
    }

    public function import(Request $request)
    {
        try {
            \Maatwebsite\Excel\Facades\Excel::import(new ImportProfile, $request->file('file'));

            return back()->with([
                'success' => 'Import danh sách Thành công!'
            ]);
        } catch (\Throwable $th) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function test()
    {
        return (new ExportExam())->download('invoices.xlsx');
    }

    public function importCertificateExcel(Request $request)
    {          
        $this->validate($request,
            [
                'name_upload' => "required|unique:transaction_waits,name_upload|unique:transactions,name_upload"
            ],
            [
                'name_upload.unique' => 'Tên đợt upload dữ liệu đã tồn tại, hãy đặt tên khác, thêm ngày tháng upload vào tên',
                'name_upload.required' => 'Cần điền tên đợt upload',
            ]
        );
        try {
            $errors = [];
            $validator = new ValidateImport;
            Excel::import($validator, $request->file('file'));
            if (count($validator->errors)) {
                foreach ($validator->errors as $key => $error) {
                    foreach ($error->messages() as $errorItem) {
                        $errors[] = $errorItem[0];
                    }
                }

                return back()->with('errorCustom', $errors);
            } else {
                Excel::import(new ImportCertificate($request->name_upload), $request->file('file'));
                $transactions = TransactionWait::where('slug', str_slug($request->name_upload))->get();

                return redirect()->route('admin.customer.certificate-list-approve');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'error' => $th->getMessage() . '/' . $th->getLine()
            ]);
        }      
    }
}
