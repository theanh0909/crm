<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportCourse;
use App\Exports\ExportCustomer;
use App\Exports\ExportCustomerTrial;
use App\Exports\ExportHashkey;
use App\Http\Controllers\Controller;
use App\Imports\ImportCourse;
use App\Imports\ImportHashkeyCustomer;
use App\Models\Email;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\LicenseRepositoryInterface;
use App\Services\Production\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CourseController extends Controller
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


    public function index(Request $request)
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

        $filters['hardware_id'] = 'KHOAHOC';


        if(!empty($inputs['use_date'])) {
            if(!empty($inputs['date'])) {
                $filters['date'] = $inputs['date'];
            }
        }

        if(!can('customer-view')) {
            $filters['user_support_id'] = auth()->user()->id;
        }

        $customers      = $this->customerRepository->filterPagination($filters, '20', 'id', 'DESC');
        $productTypes   = Product::whereIn('type', [Product::TYPE_COURSE])->get();
        $provinces      = Registered::groupBy(['customer_cty'])->select(['customer_cty'])->get();
        $users          = User::all();

        return view('admin.course.index', compact(
            'customers', 'productTypes', 'inputs', 'provinces', 'users'
        ));
    }

    public function create()
    {
        $product        = Product::where('type', Product::TYPE_COURSE)->get();
        $productDonate  = Product::where('type', Product::TYPE_SOFWTWARE)->pluck('name', 'product_type');

        return view('admin.course.create', compact(
            'product',
            'productDonate'
        ));
    }

    public function certificateCreate()
    {
        $product        = Product::where('type', Product::TYPE_CERTIFICATE)->get();
        $productDonate  = Product::where('type', Product::TYPE_SOFWTWARE)->pluck('name', 'product_type');

        return view('admin.certificates.create', compact(
            'product',
            'productDonate'
        ));
    }

    public function addCertificate(Request $request)
    {
        $inputs = $request->all();
        $inputs['user_request_id'] = auth()->user()->id;
        
    /* Logic gửi Email
        if(isset($inputs['type']) && $inputs['type'] == 0 && $inputs['customer_type'] == 0) {
            $email = Email::where('product_type', $inputs['product_type'])->first();
            if(!$email) {
                return redirect()->back()->with([
                    'error' => 'Sản phẩm chưa có template cho email, vui lòng setup!'
                ]);
            }

            $licenses = License::where('status', 0)
                ->where('product_type', $inputs['product_type'])
                ->where('license_is_registered', 0)
                ->where('license_no_computers', 1)
                ->whereNull('email_customer')
                ->where('status_register', 0)
                ->where('status_email', 0)
                ->where('exported', 0)
                ->where('exported_status', 0)
                ->where('hardware_id', 'NA')
                ->where('type_expire_date', $inputs['number_day'])
                ->limit($inputs['qty'])->get();

            if(count($licenses) < $inputs['qty']) {
                return redirect()->back()->with([
                    'error' => 'Số lượng KEY không đủ'
                ]);
            }


            for ($i = 0; $i < $inputs['qty']; $i++) {
                $license = $licenses[$i];
                $license->status_register   = 1;
                $license->status_email      = 1;
                $license->email_customer    = $inputs['customer_email'];
                $license->sell_date         = Carbon::now()->format('Y-m-d');
                $license->status_sell       = 1;
                $license->exported_status   = License::EP_EXPORT_EMAIL;
                $license->id_user           = $inputs['user_request_id'];
                $license->save();
                // SEND MAIL

                MailService::sendEmailProduct($email, $inputs['customer_email'], $inputs['customer_name'], $license->license_key, $license->status);
                MailService::sendEmailProduct($email, auth()->user()->email, $inputs['customer_name'], $license->license_key, $license->status);
            }

            $inputs['status'] = Transaction::STATUS_APPROVE;
        }
    */

        Transaction::create($inputs);

        return redirect()->route('admin.request.myRequest');
    }

    public function store(Request $request)
    {
        $inputs = $request->only([
            'customer_name',
            'product_type',
            'license_original',
            'customer_phone',
            'customer_email',
            'customer_address',
            'customer_cty',
            'note',
            'donate_key',
            'donate_product',
        ]);

        $inputs['hardware_id'] = 'KHOAHOC';
        $inputs['user_support_id'] = auth()->user()->id;

        try {
            Registered::create($inputs);

            $email = Email::where('product_type', $inputs['product_type'])->first();
            if($email) {
                MailService::sendEmailProduct(
                    $email,
                    $inputs['customer_email'],
                    $inputs['customer_name'],
                    '',
                    1
                );
            }

            return redirect()->route('admin.course.index')->with([
                'success' => 'Tạo khách hàng ' . $inputs['customer_name'] . ' Thành công!'
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e);
            return redirect()->route('admin.course.index')->with([
                'error' => 'Có lỗi xảy ra, vui lòng thử lại.'
            ]);
        }
    }


    public function edit($id)
    {
        $product = Product::where('type', Product::TYPE_COURSE)->pluck('name', 'product_type');
        $customer   = Registered::find($id);
        return view('admin.course.edit', compact(
            'product', 'customer'
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
            'note'
        ]);

        $customer = Registered::where('id', $id)->first();

        $this->customerRepository->update($customer, $inputs);

        return redirect()->route('admin.course.index')->with([
            'success' => 'Update thông tin khách hành thành công'
        ]);
    }

    public function importExcel(Request $request)
    {
        try {
            \Maatwebsite\Excel\Facades\Excel::import(new ImportCourse, $request->file('fileupload'));

            return redirect()->route('admin.course.index')->with([
                'success' => 'Import danh sách Thành công!'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.course.index')->with([
                'error' => 'Có lỗi xảy ra, vui lòng thử lại.'
            ]);
        }
    }

    public function exportExcel(Request $request)
    {
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;

        return (new ExportCourse($dateFrom, $dateTo))->download('danh-sach-hoc-vien-'.$dateFrom. '-' . $dateTo .'.xlsx');
    }
}
