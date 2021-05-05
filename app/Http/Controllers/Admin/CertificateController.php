<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Registered;
use App\User;
use App\TransactionWait;
use App\Models\Transaction;
use App\Models\Customer;
use App\Exports\ExportExam;
use App\Exports\ExportSheet1;
use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Imports\ValidateImport;
use App\Imports\ImportUpdateCertificate;
use Doctrine\Inflector\Rules\Transformations;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class CertificateController extends Controller
{
    protected $customerRepository;


    public function __construct( CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function decreeSuggest()
    {
        $data = config('config.ndcp');
        
        return json_encode(['suggestions' => $data], JSON_UNESCAPED_UNICODE);
    }

    public function updateDecree(Request $request)
    {
        try {
            $decree = str_replace(',', ';', $request->decree);

            if ($request->type == 'accept') {
                Transaction::where('id', $request->id)->update(['decree' => '']);
                Transaction::where('id', $request->id)->update(['decree' => $decree]);
            } else {
                TransactionWait::where('id', $request->id)->update(['decree' => '']);
                TransactionWait::where('id', $request->id)->update(['decree' => $decree]);
            }
            

            return response()->json('true');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        
    }

    public function contestList(Request $request)
    {
        $date_exam = ($request->date_exam) ? $request->date_exam : date('d/m/Y') . ' - ' . date('d/m/Y');
        $customer_name = ($request->customer_name) ? $request->customer_name : NULL;
        $dateStart = explode('-', $date_exam)[0];
        $dateStart = str_replace('/', '-', $dateStart);
        $dateStart = date('Y-m-d', strtotime($dateStart));

        $dateEnd = explode('-', $date_exam)[1];
        $dateEnd = str_replace('/', '-', $dateEnd);
        $dateEnd = date('Y-m-d', strtotime($dateEnd));
        $statusExam = $request->status_exam;

        if ($customer_name != NULL) {
            $contestList = Transaction::where('customer_type', 3)
                                        ->whereNotNull('name_upload')
                                        ->where('customer_name', 'like', "%$customer_name%")
                                        ->paginate(20);
        } else {
            if ($statusExam == 0) {
                $contestList = Transaction::where('customer_type', 3)
                                        ->whereNotNull('name_upload')
                                        ->where('status_exam', 0)
                                        ->paginate(20);
            } else if ($statusExam == 1) {
                $contestList = Transaction::where('customer_type', 3)
                                        ->whereNotNull('name_upload')
                                        ->where('status_exam', $statusExam)
                                        ->whereBetween('date_exam', [$dateStart, $dateEnd])
                                        ->paginate(20);
            } else if ($statusExam == 2) {
                $contestList = Transaction::where('customer_type', 3)
                                        ->whereNotNull('name_upload')
                                        ->where('status_exam', '<', $statusExam)
                                        ->paginate(20);
            }
        }

        return view('admin.certificates.contest_list', compact('date_exam', 'contestList', 'statusExam'));
    }

    public function list()
    {
        $user = auth()->user();

        if ($user->level < 1) {
            $transactions = Transaction::latest()->where('user_request_id', $user->id)->whereNotNull('name_upload')->get()->groupBy('name_upload');
        } else {
            $transactions = Transaction::latest()->whereNotNull('name_upload')->get()->groupBy('name_upload');
        }

        return view('admin.certificates.list_accept', compact('transactions'));
    }

    public function editCertificateForm($id)
    {
        $provinces = \DB::table('province')->get();
        $products = Product::where('type', 3)->get();
        $transaction = TransactionWait::findOrFail($id);

        return view('admin.certificates.edit', compact('products', 'transaction'));
    }

    public function deleteCertificate($id)
    {
        Transaction::where('id', $id)->delete();

        return back()->with('success', 'Xóa thành công');
    }

    public function editCertificate(Request $request, $id)
    {
        TransactionWait::updateOrCreate(
            [
                'id' => $id
            ],
            $request->all()
        );

        return back()->with('success', 'Sửa thành công');
    }

    public function updateDateExam(Request $request)
    {
        Transaction::where('name_upload', $request->name_upload)->update(['date_exam' => $request->date]);

        if ($request->date == NULL) {
            Transaction::where('name_upload', $request->name_upload)->update(['status_exam' => 0]);
        } else {
            Transaction::where('name_upload', $request->name_upload)->update(['status_exam' => 1]);
        }

        return response()->json('true');
    }

    public function updateDateExamItem(Request $request)
    {
        $transaction = Transaction::where('id', $request->id)->first();

    /*Chỉ những đơn chưa thanh toán hoặc chỉ admin cấp cao nhất mới được cập nhật*/    
        if (($transaction->status_salary == 0 || $transaction->status_salary == '') || auth()->user()->level == 1) {
            Transaction::where('id', $request->id)->update(['date_exam' => $request->date]);

            if ($request->date == NULL) {
                Transaction::where('name_upload', $request->name_upload)->update(['status_exam' => 0]);
            } else {
                Transaction::where('name_upload', $request->name_upload)->update(['status_exam' => 1]);
            }

            return response()->json('true');
        } else {
            return response()->json('false');
        }
    }

    public function updateRetestItem(Request $request)
    {
        Transaction::where('id', $request->id)->update(['retest' => $request->num]);
    }

    public function detailCertificateAccept($nameUpload)
    {
        $transactionDuplicate = Transaction::where('name_upload', $nameUpload)->orderBy('customer_name', 'asc')->get()->groupBy('customer_name', 'customer_email', 'customer_phone', 'product_type');
        $transactions = Transaction::where('name_upload', $nameUpload)->paginate(30);

        return view('admin.certificates.detail_accept', compact('transactions', 'nameUpload', 'transactionDuplicate'));
    }

    public function updateImportCertificate(Request $request, $nameUpload)
    {
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
            Excel::import(new ImportUpdateCertificate($nameUpload), $request->file('file'));

            return back()->with('success', 'Cập nhật thành công');
        }
    }

    public function certificateList()
    {
        try {
            $user = auth()->user();

            if ($user->level < 1) {
                $transactions = TransactionWait::latest()->where('user_id', $user->id)->whereNotNull('name_upload')->get()->groupBy('name_upload');
            } else {
                $transactions = TransactionWait::latest()->whereNotNull('name_upload')->get()->groupBy('name_upload');
            }

            return view('admin.certificates.list', compact('transactions'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function certificateDelete($name)
    {
        try {
            TransactionWait::where('slug', $name)->delete();

            return back()->with('success', 'Xóa thành công');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        
    }

    public function exportCertificateView()
    {
        //$nameUploads = Transaction::where('name_upload', '!=', '')->get()->groupBy('name_upload');

        return view('admin.certificates.export');
    }

    public function exportCertificate(Request $request)
    {
        $inputs = $request->all();

        if ($inputs['type'] == 1) {
            // trích ngang
            $sheets = Transaction::where('date_exam', $inputs['date_exam'])->get()->groupBy('type_exam');

            return (new ExportExam($inputs['date_exam'], $sheets))->download(date('d-m-Y') . ".xlsx");
        } else if ($inputs['type'] == 0) {
            // sheet 1            
            return Excel::download(new ExportSheet1(
                $inputs['date_exam']
            ), date('d-m-Y') . '.xlsx');
            //return (new ExportSheet1($inputs['date_exam']))->download("test1997.xlsx");
        }
        
    }

    public function acceptItem($id)
    {
        try {
            DB::beginTransaction();
            $item = TransactionWait::where('id', $id)->first();
            $customer = Customer::updateOrCreate(
                [
                    'email' => $item->customer_email
                ],[
                    'name' => $item->customer_name,
                    'phone' => $item->customer_phone,
                    'address' => $item->customer_address,
                    'birthday' => $item->customer_birthday,
                    'company' => $item->company,
                    'school' => $item->school,
                    'nation' => $item->nation,
                    'id_card' => $item->id_card,
                    'date_card' => $item->date_card,
                    'qualification' => $item->qualification,
                    'address_card' => $item->address_card,
                    'city' => $item->customer_city,
                    'edu_system' => $item->edu_system,
                    'exper_num' => $item->exper_num
                ]
            );
            Transaction::updateOrcreate(
                [
                    'name_upload' => $item->slug,
                    'product_type' => $item->product_type,
                    'customer_id' => $customer->id
                ],
                [
                    'user_request_id' => $item->user_id,
                    'status' => 0,
                    'customer_type' => 3,
                    'price' => $item->price,
                    'discount' => $item->discount,
                    'retest' => $item->retest,
                    'customer_account' => $item->customer_account,
                    'decree' => $item->decree,
                    'type_exam' => $item->type_exam,
                    'class' => $item->class,
                    'collaborator' => $item->collaborator,
                    'note' => $item->note,
                ]
            );
            $sale = Sale::create([
                'user_id' => $item->user_id,
                'customer_name' => $item->customer_name,
                'customer_phone' => $item->customer_phone,
                'customer_email' => $item->customer_email,
                'customer_address' => $item->customer_address,
                'customer_city' => $item->customer_city,
                'total' => $item->price,
                'prepaid' => $item->prepaid,
                'status_prepaid' => ($item->price > $item->prepaid) ? 1 : 0,
                'note' => $item->note,
                'name_upload' => $item->slug
            ]);

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product' => $item->product_type,
                'product_type' => 3,
                'qty' => 1,
                'price' => $item->price,
                'discount' => $item->discount,
            ]); 
            
            TransactionWait::where('id', $id)->delete();
            DB::commit();

            return back()->with('success', 'Xác nhận thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage() . $th->getLine());
        }
    }

    public function certificateAccept($name)
    {
        try {
            DB::beginTransaction();
            $transactionWait = TransactionWait::where('slug', $name)->get();

            foreach ($transactionWait as $item) {
                $customer = Customer::updateOrCreate(
                    [
                        'email' => $item->customer_email
                    ],[
                        'name' => $item->customer_name,
                        'phone' => $item->customer_phone,
                        'address' => $item->customer_address,
                        'birthday' => $item->customer_birthday,
                        'company' => $item->company,
                        'school' => $item->school,
                        'nation' => $item->nation,
                        'id_card' => $item->id_card,
                        'date_card' => $item->date_card,
                        'qualification' => $item->qualification,
                        'address_card' => $item->address_card,
                        'city' => $item->customer_city,
                        'exper_num' => $item->exper_num,
                        'edu_system' => $item->edu_system
                    ]
                );
                Transaction::updateOrCreate(
                    [
                        'product_type' => $item->product_type,
                        'name_upload' => $item->slug,
                        'customer_id' => $customer->id
                    ],
                    [
                        'user_request_id' => $item->user_id,
                        'status' => 0,
                        'customer_type' => 3,
                        'price' => $item->price,
                        'discount' => $item->discount,
                        'retest' => $item->retest,
                        'customer_account' => $item->customer_account,
                        'decree' => $item->decree,
                        'type_exam' => $item->type_exam,
                        'class' => $item->class,
                        'collaborator' => $item->collaborator,
                        'note' => $item->note
                    ]
                );
                $sale = Sale::create([
                    'user_id' => $item->user_id,
                    'customer_name' => $item->customer_name,
                    'customer_phone' => $item->customer_phone,
                    'customer_email' => $item->customer_email,
                    'customer_address' => $item->customer_address,
                    'customer_city' => $item->customer_city,
                    'total' => $item->price,
                    'prepaid' => $item->prepaid,
                    'status_prepaid' => ($item->price > $item->prepaid) ? 1 : 0,
                    'note' => $item->note,
                    'name_upload' => $item->slug
                ]);

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product' => $item->product_type,
                    'product_type' => 3,
                    'qty' => 1,
                    'price' => $item->price,
                    'discount' => $item->discount,
                ]); 
            }
            TransactionWait::where('slug', $name)->delete();
            DB::commit();

            return back()->with('success', 'Xác nhận thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage() . $th->getLine());
        }
    }

    public function merge(Request $request)
    {
        try {
            $nameUpload = $request->nameUpload;
            $nameUploadUpdate = $nameUpload[0];
            $table = $request->table;
            
            if ($table == 'transactions') {
                foreach ($nameUpload as $nameItem) {
                    Transaction::where('name_upload', $nameItem)->update(['name_upload' => $nameUploadUpdate]);
                }
            } else if ($table == 'transaction_wait') {
                foreach ($nameUpload as $nameItem) {
                    TransactionWait::where('name_upload', $nameItem)->update(['name_upload' => $nameUploadUpdate]);
                }
            }

            return back()->with('success', 'Gộp thành công');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function certificateDetail($name)
    {
        $transactionDuplicate = TransactionWait::where('name_upload', $name)->orderBy('customer_name', 'asc')->get()->groupBy('customer_name', 'customer_email', 'customer_phone', 'product_type');
        $transactions = TransactionWait::where('name_upload', $name)->paginate(20);

        return view('admin.certificates.detail', compact('transactions', 'transactionDuplicate'));
    }

    public function certificateIndex (Request $request)
    {
        $inputs = $request->only([
            'query', 'product_type','date','customer_cty', 'use_date'
        ]);

        $filters = [];
        if(!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        }
        if(!empty($inputs['customer_cty'])) {
            $filters['customer_cty'] = $inputs['customer_cty'];
        }

        $filters['hardware_id'] = 'CHUNGCHI';

        if(!empty($inputs['use_date'])) {
            if(!empty($inputs['date'])) {
                $filters['date'] = $inputs['date'];
            }
        }

        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }

        $customers      = $this->customerRepository->filterPagination($filters, '20', 'id', 'DESC');
        $productTypes   = Product::whereIn('type', [Product::TYPE_CERTIFICATE])->get();
        $provinces      = Registered::groupBy(['customer_cty'])->select(['customer_cty'])->get();
        $users          = User::all();

        return view('admin.certificates.index', compact(
            'customers', 'productTypes', 'inputs', 'provinces', 'users'
        ));
    }
}
