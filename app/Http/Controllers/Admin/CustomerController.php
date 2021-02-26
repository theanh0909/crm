<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportCustomer;
use App\Exports\ExportCustomerTrial;
use App\Exports\ExportHashkey;
use App\Exports\ExportCertificate;
use App\Http\Controllers\Controller;
use App\Imports\ImportHashkeyCustomer;
use App\Imports\ImportCertificate;
use App\Models\Email;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Models\Transaction;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\LicenseRepositoryInterface;
use App\Services\Production\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Response;

class CustomerController extends Controller
{
    protected $customerRepository;

    protected $licenseRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        LicenseRepositoryInterface $licenseRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->licenseRepository  = $licenseRepository;
    }

    public function importCertificateForm()
    {
        return view('admin.certificates.import');
    }

    public function deleteCertificate($id)
    {
        DB::table('transaction_waits')->where('id', $id)->delete();

        return back()->with('success', 'Xóa thành công');
    }

    public function importCertificate(Request $request)
    {
        $this->validate($request,
            [
                'name_upload' => 'unique:transaction_waits,name_upload'
            ],
            [
                'name_upload.unique' => 'Tên đợt upload dữ liệu đã tồn tại, hãy đặt tên khác, thêm ngày tháng upload vào tên'
            ]
        );
        try {
            \Maatwebsite\Excel\Facades\Excel::import(new ImportCertificate($request->name_upload), $request->file('file'));
            $transactions = DB::table('transaction_waits')->where('name_upload', $request->name_upload)->get();

            return redirect()->route('admin.customer.certificate-list-approve');
        } catch (\Exception $e) {

            return redirect()->back()->with([
                'error' => $e->getMessage() . '/' . $e->getLine()
            ]);
        }
    }

    public function print($id)
    {
        $registered = Registered::findOrFail($id);

        return view('admin.customer.print', compact('registered'));
    }

    public function index(Request $request)
    {
        $inputs = $request->only([
            'query', 'product_type','date','customer_cty', 'use_date'
        ]);

        $filters = [
            'khoamem' => true,
        ];
        if(!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        }
        if(!empty($inputs['customer_cty'])) {
            $filters['customer_cty'] = $inputs['customer_cty'];
        }

        if(!empty($inputs['use_date'])) {
            if(!empty($inputs['date'])) {
                $filters['date'] = $inputs['date'];
            } else {
                $filters['date'] = Carbon::now()->addDays(-30)->format('Y/m/d') . '-' . Carbon::now()->format('Y/m/d');
            }
        }

        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }

        $customers      = $this->customerRepository->filterPagination($filters, '20', 'id', 'DESC');
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();
        $provinces      = Registered::groupBy(['customer_cty'])->select(['customer_cty'])->get();
        $users          = User::all();
        //dd($customers);
        return view('admin.customer.index', compact(
            'customers', 'productTypes', 'inputs', 'provinces', 'users'
        ));
    }

    public function noPaid(Request $request)
    {
        $userId = auth()->user()->id;
        $name = NULL;
        
        if (!empty($request->name)) {
            $sales = Sale::latest()->where('customer_name', 'like', '%' . $request->name . '%')
                                   ->orWhere('customer_phone', 'like', '%' . $request->name . '%')
                                   ->orWhere('customer_email', 'like', '%' . $request->name . '%')
                                   ->paginate(10);
            $name = $request->name;
        } else {
            $sales = Sale::latest()->paginate(10);
        }
        
        return view('admin.customer.no_paid', compact('sales', 'name'));
    }

    public function confirmPay($id)
    {
        try {
            if (auth()->user()->level > 0) {
                Sale::where('id', $id)->update(['status_prepaid' => 0]);
            } else {
                Sale::where('id', $id)->update(['status_prepaid' => 2]);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

        return back()->with('success', 'Xác nhận thành công');
    }

    public function editCertificateForm($id)
    {
        $transaction = Transaction::findOrFail($id);

        return view('admin.certificates.edit_accept', compact('transaction'));
    }

    public function editCertificate(Request $request, $id)
    {
        Transaction::updateOrCreate(
            [
                'id' => $id
            ],
            $request->all()
        );

        return back()->with('success', 'Sửa thành công');
    }

    public function activeToday(Request $request)
    {
        $filters['last_runing_date'] = Carbon::now()->format('Y-m-d');

        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }
        $customers = $this->customerRepository->filterPagination($filters, 20);

        return view('admin.customer.today', compact(
            'customers'
        ));
    }

    public function customerPaid($id)
    {
        $license = License::where('id', $id)->first();
        $license->status_sell = 0;
        $license->save();

        return redirect()->route('admin.customer.noPaid');
    }

    public function resetKey($id)
    {

            $customer = Registered::where('id', $id)->first();
            $customer->hardware_id = 'EDIT_ID_HARDWARE';
            $customer->number_can_change_key = $customer->number_can_change_key + 1;
            $customer->save();

            $license = $customer->license;
            $license->hardware_id = 'EDIT_ID_HARDWARE';
            $license->save();

            $key = 'mail_remake_key_success';
            $resultMail = MailService::sendMailAfterRegister($customer->customer_email, $key);
            if($resultMail)
                return redirect()->back()->with([
                    'success' => "Đặt lại key thành công khách hàng " . $customer->customer_email,
                ]);

            return redirect()->route('admin.customer.index')->with([
                'error' => "Có lỗi xảy ra, Đã reset HardwareID thành công nhưng email chưa được gửi đến khách hàng, vui lòng liên hệ với khách hàng",
            ]);
    }

    public function edit($id)
    {
        $customer = Registered::where('id', $id)->first();
        $listProduct = Product::where('type', $customer->product->type)->get();

        if($customer->hardware_id == 'KHOACUNG') {
            $product = Product::where('type', Product::TYPE_HARDWARE)->pluck('name', 'product_type');
        } elseif ($customer->hardware_id == 'KHOAHOC') {
            $product = Product::where('type', Product::TYPE_COURSE)->pluck('name', 'product_type');
        } else {
            $product = Product::where('type', Product::TYPE_SOFWTWARE)->pluck('name', 'product_type');
        }

        return view('admin.customer.edit', compact(
            'customer',
            'product',
            'listProduct'
        ));
    }

    public function update($id, Request $request)
    {
        $inputs = $request->only([
            'customer_name',
            'customer_email',
            'customer_phone',
            'customer_address',
            'customer_cty',
            'number_can_change_key',
            'license_expire_date',
            'license_status',
            'product_type'
        ]);
        $customer = Registered::where('id', $id)->with(['license'])->first();
        
        if($customer->license) {
            if($customer->product_type !== $inputs['product_type'] || $customer->license->status !== $inputs['license_status']) {
                $license = $customer->license;
                $license->product_type = $inputs['product_type'];
                $license->status       = $inputs['license_status'];
                $license->save();
            }
        } else {
            unset($inputs['license_status'], $inputs['product_type']);
        }

        if ($customer->transaction_id != '') {
            $product = Product::where('product_type', $request->product_type)->first();
            Transaction::where('id', $customer->transaction_id)->update([
                'product_type' => $request->product_type,
                'price' => $product->price
            ]);
        }
        Registered::where('id', $id)->update([
            'product_type' => $request->product_type,
            'price' => $customer->product->price
        ]);

        $this->customerRepository->update($customer, $inputs);

        return back()->with('success', 'Cập nhật thành công');
        // return redirect()->route('admin.customer.index')->with([
        //     'success' => 'Update thông tin khách hành thành công'
        // ]);
    }

    public function delete($id)
    {
        $customer = Registered::find($id);
        if($customer) {
            if($customer->license) {
                $customer->license->delete();
            }
            $customer->delete();
        }

        return redirect()->back()->with([
            'success' => 'Xóa thành công!'
        ]);
    }


    public function getRenewed($id)
    {
        $typeExpireDate = [
            '7'     => '7 Ngày',
            '15'    => '15 Ngày',
            '30'    => '1 Tháng',
            '60'    => '2 Tháng',
            '90'    => '3 Tháng',
            '120'   => '4 Tháng',
            '150'   => '5 Tháng',
            '180'   => '6 Tháng',
            '210'   => '7 Tháng',
            '240'   => '8 Tháng',
            '270'   => '9 Tháng',
            '300'   => '10 Tháng',
            '330'   => '11 Tháng',
            '365'   => '1 Năm',
            '730'   => '2 Năm',
            '1095'  => '3 Năm',
            '1460'  => '4 Năm',
            '1852'  => '5 Năm',
            '3650'  => '10 Năm',
        ];

        $customer = Registered::where('id', $id)->first();
        return view('admin.customer.renewed', compact('customer', 'typeExpireDate'));
    }

    public function postRenewed($id, Request $request)
    {

        $renewed    = $request->renewed;
        $customer   = Registered::where('id', $id)->first();

        $customer->license_expire_date = Carbon::parse($customer->license_expire_date)->addDays($renewed)->format('Y-m-d');
        $customer->save();

        $key = 'mail_renewed_key_success';
        $resultMail = MailService::sendMailAfterRegister($customer->customer_email, $key);
        if($resultMail)
            return redirect()->route('admin.customer.index')->with([
                'success' => "Gia hạn thành công - $renewed ngày cho khách hàng: " . $customer->customer_email,
            ]);

        return redirect()->route('admin.customer.index')->with([
            'error' => "Có lỗi xảy ra, Đã gia hạn thành công nhưng email chưa được gửi đến khách hàng, vui lòng liên hệ với khách hàng",
        ]);
    }

    public function editComment(Request $request)
    {
        $id = $request->id;
        $note = $request->note;
        $table = $request->table;

        if ($table == 'registered') {
            $customer = Registered::where('id', $id)->first();
            Registered::whereId($id)->update(['note' => $note]);

            if ($customer->transaction_id != '') {
                $transaction = Transaction::findOrFail($customer->transaction_id);
                $transaction->note = $note;
                $transaction->save();
            }
                
            return response()->json(true);
        } else if ($table == 'transactions') {
            Transaction::where('id', $id)->update(['note' => $note]);

            return response()->json(true);
        }
        
    }

    public function editBackground(Request $request)
    {
        $id = $request->id;
        $background = $request->background;

        $customer = Registered::where('id', $id)->first();
        $customer->background = $background;
        $customer->save();

        return $background;
    }

    public function listHashKeyCustomer(Request $request)
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

        $filters['hardware_id'] = 'KHOACUNG';


        if(!empty($inputs['use_date'])) {
            if(!empty($inputs['date'])) {
                $filters['date'] = $inputs['date'];
            }
        }

        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }

        $customers      = $this->customerRepository->filterPagination($filters, '20', 'id', 'DESC');
        $productTypes   = Product::whereIn('type', [Product::TYPE_HARDWARE])->get();
        $provinces      = Registered::groupBy(['customer_cty'])->select(['customer_cty'])->get();
        $users          = User::all();
        
        return view('admin.customer.list_hashkey', compact(
            'customers', 'productTypes', 'inputs', 'provinces', 'users'
        ));
    }

    public function hashKeyCustomer()
    {
        $product = Product::where('type', Product::TYPE_HARDWARE)->get();

        return view('admin.customer.create_hashkey', compact(
            'product'
        ));
    }

    public function createHashKeyCustomer(Request $request)
    {
        $inputs = $request->only([
            'customer_name',
            'product_type',
            'license_original',
            'customer_phone',
            'customer_email',
            'customer_address',
            'note'
        ]);

        $inputs['hardware_id'] = 'KHOACUNG';
        $inputs['user_support_id'] = auth()->user()->id;

        try {
            Registered::create($inputs);

            $email = Email::where('product_type', $inputs['product_type'])->first();
            if($email) {
                MailService::sendEmailProduct(
                    '',
                    $inputs['customer_email'],
                    $inputs['customer_name'],
                    $inputs['license_original'],
                    1
                );
            }

            return redirect()->route('admin.customer.hashKeyCustomer')->with([
                'success' => 'Tạo khóa cứng cho khách hàng ' . $inputs['customer_name'] . ' Thành công!'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.customer.hashKeyCustomer')->with([
                'error' => 'Có lỗi xảy ra, vui lòng thử lại.'
            ]);
        }
    }

    public function exportHashKeyCustomer(Request $request)
    {
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;

        return (new ExportHashkey($dateFrom, $dateTo))->download('khach-hang-su-dung-khoa-cung-'.$dateFrom. '-' . $dateTo .'.xlsx');

    }

    public function exportCertificateCustomer(Request $request)
    {
        
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;
        return (new ExportCertificate($dateFrom, $dateTo))->download('danh-sach-dang-ky-thi-chung-chi-'.$dateFrom. '-' . $dateTo .'.xlsx');
    }

    public function exportCustomer(Request $request)
    {
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;

        return (new ExportCustomer($dateFrom, $dateTo))->download('danh-sach-khach-hang-'.$dateFrom. '-' . $dateTo .'.xlsx');
    }

    public function importListHashKeyCustomer(Request $request)
    {
        try {
            \Maatwebsite\Excel\Facades\Excel::import(new ImportHashkeyCustomer, $request->file('fileupload'));

            return redirect()->route('admin.customer.listHashKeyCustomer')->with([
                'success' => 'Import danh sách Thành công!'
            ]);
        } catch (\Exception $e) {

            return redirect()->route('admin.customer.listHashKeyCustomer')->with([
                'error' => $e->getMessage()
            ]);
        }
    }



    public function trial(Request $request)
    {
        $inputs = $request->only([
            'query', 'product_type','date','customer_cty', 'use_date'
        ]);

        $filters = [
            'license_status'    => 0,
            'khoamem'           => true,
        ];
        if(!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        }
        if(!empty($inputs['customer_cty'])) {
            $filters['customer_cty'] = $inputs['customer_cty'];
        }

        if(!empty($inputs['use_date'])) {
            if(!empty($inputs['date'])) {
                $filters['date'] = $inputs['date'];
            } else {
                $filters['date'] = Carbon::now()->addDays(-30)->format('Y/m/d') . '-' . Carbon::now()->format('Y/m/d');
            }
        }

        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }

        $customers      = $this->customerRepository->filterPagination($filters, '20', 'id', 'DESC');
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();
        $provinces      = Registered::groupBy(['customer_cty'])->select(['customer_cty'])->get();

        return view('admin.customer.trial', compact(
            'customers', 'productTypes', 'inputs', 'provinces'
        ));
    }

    public function exportCustomerTrial(Request $request)
    {
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;

        return (new ExportCustomerTrial($dateFrom, $dateTo))->download('danh-sach-khach-hang-dung-thu-'.$dateFrom. '-' . $dateTo .'.xlsx');
    }

    public function changeUser(Request $request)
    {
        $userID     = $request->user_id;
        $customerID = $request->customer_id;

        $customer   = Registered::find($customerID);
        if($customer) {
            $customer->user_support_id = $userID;
            $customer->save();
        }

        return redirect()->back()->with([
            'success' => 'Chuyển NV thành công'
        ]);
    }

    public function resendEmail($id)
    {
        $customer = Registered::find($id);
        if($customer) {
            $email = Email::where('product_type', $customer->product_type)->first();
            if(!$email) {
                return redirect()->back()->with([
                    'error' => 'Sản phẩm chưa có template cho email, vui lòng setup!'
                ]);
            }

            $license = $customer->license;
            if(!$license) {
                return redirect()->back()->with([
                    'error' => 'Có lỗi, vui lòng thử lại'
                ]);
            }

            try{
                MailService::sendEmailProduct($email, $customer->customer_email, $customer->customer_name, $license->license_key, $license->status);
                return redirect()->back()->with([
                    'success' => 'Đã gửi lại Email cài đặt cho user: ' . $customer->customer_email,
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'error' => 'Có lỗi, vui lòng thử lại'
                ]);
            }
        }

        return redirect()->back()->with([
            'error' => 'Có lỗi, vui lòng thử lại'
        ]);
    }

    public function blockKey($id)
    {
        $customer = Registered::find($id);
        if($customer) {
            $customer->license_expire_date = Carbon::now()->addDays('-1')->format('Y-m-d');
            $customer->save();
        }

        return redirect()->back()->with([
            'success' => 'Khóa Key thành công',
        ]);
    }
    public function classify()
    {
        return view("admin.customer.classify");
    }

    public function notActived()
    {
        try {
        // đối chiếu vào bảng licenses: nếu có email và chưa kích hoạt thì lọc
            $licenses = License::where('email_customer', '!=', '')
                                ->whereDoesntHave('registered')
                                ->latest()
                                ->paginate(20);
        
            return view('admin.customer.not_active', compact('licenses'));
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
