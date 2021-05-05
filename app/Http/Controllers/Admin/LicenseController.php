<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportLicense;
use App\Exports\LicenseAfterCreateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\License\SendKeyRequest;
use App\Http\Requests\Admin\License\StoreRequest;
use App\Http\Requests\Admin\License\UpdateRequest;
use App\Models\Email;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Models\ProductType;
use App\Models\Transaction;
use App\Repositories\LicenseRepositoryInterface;
use App\Services\Production\LicenseService;
use App\Services\Production\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel;

class LicenseController extends Controller
{

    protected $licenseService;

    protected $licenseRepository;

    public function __construct(
        LicenseService $licenseService, //Thao tac voi DB
        LicenseRepositoryInterface $licenseRepository //Interface tương tác với license
    )
    {
        $this->licenseService     = $licenseService;
        $this->licenseRepository  = $licenseRepository;
    }


    public function notActived(Request $request)
    {
        $inputs = $request->only([
            'query', 'status','product_type',
        ]);

        $filters = [
            'status_register' => License::KEY_NOT_ACTIVE,
            'exported_status' => License::EP_FREE,
            'status_email'    => 0,
        ];
        $filters['query'] = $filters['status'] = $filters['product_type'] = NULL;

        if(!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if(!is_blank($request->get('status'))) {
            $filters['status'] = $request->get('status');
            $inputs['status'] = $request->get('status');
        } else {
            $inputs['status'] = 1;
            $filters['status'] = 1;
        }
        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        }

        $relationship = [
            'customer',
            'product'
        ];

        $licenses      = $this->licenseRepository->filterPagination($filters, 20, 'id', 'desc', $relationship);
        //dd($licenses);
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();
        //dd($productTypes);

        $pageActive = false;

        $title = "Danh sách Key chờ gửi đi";
        $pageAlias = 'notactive';
        

        return view('admin.license.index', compact(
            'licenses', 'productTypes', 'inputs', 'pageActive', 'title', 'pageAlias', 'filters'
        ));
    }


    public function actived(Request $request)
    {
        $inputs = $request->only([
            'query', 'status','product_type',
        ]);

        $filters = [
            'status_register' => License::KEY_ACTIVE,
        ];
        $filters['query'] = $filters['status'] = $filters['product_type'] = NULL;

        if(!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if(!is_blank($request->get('status'))) {
            $filters['status'] = $request->get('status');
        }else {
            $inputs['status'] = 0;
            $filters['status'] = 0;
        }

        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        }

        $relationship = [
            'customer',
            'product'
        ];
        $licenses      = $this->licenseRepository->filterPagination($filters, 20, 'id', 'desc', $relationship);
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();

        $pageActive = true;
        $title = "Danh sách Key đã kích hoạt";
        $pageAlias = 'actived';

        return view('admin.license.index', compact(
            'licenses', 'productTypes', 'inputs', 'pageActive', 'title', 'pageAlias', 'filters'
        ));
    }

    public function exported(Request $request)
    {
        $inputs = $request->only([
            'query', 'status','product_type',
        ]);

        $filters = [
            'exported_status' => License::EP_EXPORT_EXCEL,
        ];
        $filters['query'] = $filters['status'] = $filters['product_type'] = NULL;

        if(!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if(!is_blank($request->get('status'))) {
            $filters['status'] = $request->get('status');
        }else {
            $inputs['status'] = 1;
            $filters['status'] = 0;
        }

        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        }

        $relationship = [
            'customer',
            'product'
        ];

        $licenses      = $this->licenseRepository->filterPagination($filters, 20, 'id', 'desc', $relationship);
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();

        $pageActive = false;
        $title = "Danh sách Key đã export ra excel";
        $pageAlias = 'exported';

        return view('admin.license.index', compact(
            'licenses', 'productTypes', 'inputs', 'pageActive','title', 'pageAlias', 'filters'
        ));
    }


    public function exportApi(Request $request)
    {
        $inputs = $request->only([
            'query', 'status','product_type',
        ]);

        $filters = [
            'exported_status' => License::EP_EXPORT_API,
        ];
        $filters['query'] = $filters['status'] = $filters['product_type'] = NULL;
        
        if(!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if(!is_blank($request->get('status'))) {
            $filters['status'] = $request->get('status');
        }else {
            $inputs['status'] = 1;
            $filters['status'] = 0;
        }

        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        }

        $relationship = [
            'customer',
            'product'
        ];

        $licenses      = $this->licenseRepository->filterPagination($filters, 20, 'id', 'desc', $relationship);
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();

        $pageActive = false;
        $title = "Danh sách Key đã export ra API";
        $pageAlias = 'exportapi';

        return view('admin.license.index', compact(
            'licenses', 'productTypes', 'inputs', 'pageActive','title', 'pageAlias', 'filters'
        ));
    }


    public function emailSended(Request $request)
    {
        $inputs = $request->only([
            'query', 'status','product_type',
        ]);

        $filters = [
            'exported_status' => License::EP_EXPORT_EMAIL,
        ];
        $filters['query'] = $filters['status'] = $filters['product_type'] = NULL;

        if (!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if (!is_blank($request->get('status'))) {
            $filters['status'] = $request->get('status');
        } else {
            $inputs['status'] = 1;
            $filters['status'] = 0;
        }

        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        }


        $relationship = [
            'customer',
            'product'
        ];

        $licenses      = $this->licenseRepository->filterPagination($filters, 20, 'updated_at', 'desc', $relationship);
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();
        $pageActive = false;
        $title = "Danh sách Key đã gửi qua email";
        $pageAlias = 'emailsended';
        //dd($filters);

        return view('admin.license.index', compact(
            'licenses', 'productTypes', 'inputs', 'pageActive','title', 'pageAlias', 'filters'
        ));
    }

    public function emailSendedToday(Request $request)
    {
        $inputs = $request->only([
            'query', 'status','product_type',
        ]);

        $filters = [
            'exported_status' => License::EP_EXPORT_EMAIL,
            'updated_at'      => Carbon::now()->format('Y-m-d'),
        ];
        if (!empty($inputs['query'])) {
            $filters['query'] = $inputs['query'];
        }
        if (!is_blank($request->get('status'))) {
            $filters['status'] = $request->get('status');
        } else {
            $inputs['status'] = 1;
            $filters['status'] = 0;
        }

        if(!empty($inputs['product_type'])) {
            $filters['product_type'] = $inputs['product_type'];
        } else {
            $filters['product_type'] = 'DutoanGXD2020'; // mặc định là dự toán
        }

        $relationship = [
            'customer',
            'product'
        ];

        $licenses      = $this->licenseRepository->filterPagination($filters, 20, 'updated_at', 'desc', $relationship);
        //dd($licenses);
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();

        $pageActive = false;
        $title = "Danh sách Key đã gửi qua email";
        $pageAlias = 'emailsended';

        return view('admin.license.send_email_today', compact(
            'licenses', 'productTypes', 'inputs', 'pageActive','title', 'pageAlias'
        ));
    }

    public function edit($id)
    {
        $license        = $this->licenseRepository->firstByKey($id);
        if(!$license) {
            return redirect()->route('admin.license.not-actived');
        }
        $products = Product::where('type', Product::TYPE_SOFWTWARE)->pluck('name', 'product_type');

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

        $users = User::all()->pluck('fullname', 'id');

        return view('admin.license.edit', compact(
            'license', 'products', 'typeExpireDate', 'users'
        ));
    }

    public function update(UpdateRequest $request, $id)
    {
        $license = $this->licenseRepository->firstByKey($id);
        $inputs = $request->only([
            'status',
            'product_type',
            'type_expire_date',
            'license_no_computers',
            'license_no_instance',
            'id_user',
            'license_created_date',
        ]);

        $this->licenseRepository->update($license, $inputs);

        if($license->status_register == License::KEY_NOT_ACTIVE) {
            return redirect()->route('admin.license.not-actived')->with([
                'success' => 'Update key thành công',
            ]);
        }
        return redirect()->route('admin.license.actived')->with([
            'success' => 'Update key thành công',
        ]);

    }

    public function updateEmail(Request $request, $id)
    {
        $license = $this->licenseRepository->firstByKey($id);
        $inputs = $request->only([
            'email_customer',
        ]);

        $this->licenseRepository->update($license, $inputs);

        return redirect()->back();

    }

    public function sendMailCustomer($id)
    {
        $license = $this->licenseRepository->firstByKey($id);
        if($license->email_customer == '') {
            return redirect()->back()->with([
                'error' => "Email khách hàng nhận không hợp lệ, vui lòng kiểm tra lại",
            ]);
        }
        $email = Email::where('product_type', $license->product_type)->first();
        if(!$email) {
            return redirect()->back()->with([
                'error' => "Chưa cài đặt nội dung email cho phần mềm, vui lòng kiểm tra lại",
            ]);
        }

        try {
            MailService::sendEmailProduct($email, $license->email_customer, 'Quý khách', $license->license_key, $license->status);

            $license->status_email      = 1;
            $license->exported_status   = License::EP_EXPORT_EMAIL;
            $license->save();

            return redirect()->back()->with([
                'success' => "Gửi key thành công",
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => "Có lỗi, vui lòng thử lại",
            ]);
        }

    }

    public function keyStore()
    {
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)
                                ->with('license')
                                ->get();

        return view('admin.license.key_store', compact('productTypes'));
    }

    public function create()
    {
        $products = Product::where('type', Product::TYPE_SOFWTWARE)->pluck('name', 'product_type');
        $productTypes   = Product::where('type', Product::TYPE_SOFWTWARE)->get();

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

        $users = User::all()->pluck('fullname', 'id');

        return view('admin.license.create', compact(
            'products', 'typeExpireDate', 'users', 'productTypes'
        ));
    }

    public function store(StoreRequest $request)
    {
        $inputs = $request->only([
            'status',
            'product_type',
            'type_expire_date',
            'no_keys',
            'license_no_computers',
            'license_no_instance',
            'id_user',
            'status_email',
            'license_created_date',
        ]);

        $inputs['hardware_id']          = 'NA';
        $inputs['license_created_date'] = Carbon::now()->format('Y-m-d');

        try {
            $datas = $this->licenseService->createNewLicenseKey($inputs);

            return view('admin.license.after_create', compact(
                'datas'
            ));
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }

    public function destroy($id)
    {
        $license        = $this->licenseRepository->firstByKey($id);
        Registered::where('license_original', $license->license_key)->delete();
        Transaction::where('license_id', $license->id)->delete();
        
        if(!$license) {
            return back()->with('success', 'Xóa key thành công');
        }

        $this->licenseRepository->delete($license);

        return back()->with('success', 'Xóa key thành công');
    }

    public function sendKey()
    {
        $products = Product::where('type', Product::TYPE_SOFWTWARE)->pluck('name', 'product_type');
        $users    = User::all()->pluck('fullname', 'id');
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


        return view('admin.license.send_key', compact(
            'products', 'users', 'typeExpireDate'
        ));
    }

    public function postSendKey(SendKeyRequest $request)
    {
        $inputs = $request->only([
            'email_customer',
            'product_type',
            'id_user',
            'status',
            'n_key',
            'status_sell',
            'type_expire_date',
            'customer_name',
            'customer_phone'
        ]);

        if(isset($inputs['status_sell']) && !empty($inputs['status_sell'])) {
            $inputs['status_sell'] = 0;
        } else {
            $inputs['status_sell'] = 1;
        }

        $email = Email::where('product_type', $inputs['product_type'])->first();
        if(!$email) {
            return redirect()->back()->with([
                'error' => 'Sản phẩm chưa có template cho email, vui lòng setup!'
            ]);
        }

        $query = License::where('product_type', $inputs['product_type'])
                                ->where('license_is_registered', 0)
                                ->where('status', $inputs['status'])
                                ->where('type_expire_date', $inputs['type_expire_date'])
                                ->where('license_no_computers', 1)
                                ->whereNull('email_customer')
                                ->where('status_email', 0)
                                ->where('exported', 0);

        $count = $query->count();
        if($count < $inputs['n_key']) {
            return redirect()->back()->with([
                'error' => 'Số lượng Key trong kho không đủ, vui lòng tạo thêm key'
            ]);
        }


        $licenses   = $query->limit($inputs['n_key'])->get();
        $user       = User::find($inputs['id_user']);

        $error = 0;
        DB::beginTransaction();
        for ($i = 0; $i < $inputs['n_key']; $i++) {
            try {
                $license = $licenses[$i];
                $license->status_register   = 1;
                $license->status_email      = 1;
                $license->email_customer    = $inputs['email_customer'];
                $license->customer_phone    = $inputs['customer_phone'];
                $license->sell_date         = Carbon::now()->format('Y-m-d');
                $license->status_sell       = $inputs['status_sell'];
                $license->exported_status   = License::EP_EXPORT_EMAIL;
                $license->save();
                // SEND MAIL

                MailService::sendEmailProduct($email, $license->email_customer, $inputs['customer_name'], $license->license_key, $license->status);
                MailService::sendEmailProduct($email, $user->email, $inputs['customer_name'], $license->license_key, $license->status);

            } catch (\Exception $e) {
                $error++;
            }
        }
        if($error > 0) {
            DB::rollBack();
            return redirect()->back()->with([
                'error' => 'Có lỗi xảy ra, vui lòng thử lại'
            ]);
        }

        DB::commit();
        return redirect()->back()->with([
            'success' => "Gửi " . $inputs['n_key'] . " Thành công đến khách hàng " . $inputs['email_customer']
        ]);

    }
    public function exportExcelSelected(Request $request)
    {
        try{
            $inputs = $request->only(['id']);
            License::whereIn('id', $inputs['id'])->update(['exported_status' => License::EP_EXPORT_EXCEL]);

            return (new LicenseAfterCreateExport($inputs['id']))->download('list-license-export-'.Carbon::now()->format('Y-m-d').'.xlsx');
        } catch (\Exception $e) {

            echo "Có lỗi, vui lòng thử lại"; die;
        }
    }

    public function exportExcel(Request $request)
    {
        try{
            $inputs = $request->only(['status', 'qty', 'product_type']);
            $count  = License::where('status', $inputs['status'])
                ->where('product_type', $inputs['product_type'])
                ->where('status_email', 0)
                ->where('exported', 0)
                ->where('status_register',License::KEY_NOT_ACTIVE)
                ->count();

            if($count < $inputs['qty']) {
                echo "Số lượng Key không đủ, vui lòng kiểm tra lại"; die;
            }

            return (new ExportLicense(
                $inputs['product_type'],
                $inputs['status'],
                $inputs['qty']
            ))->download('list-license-export-'.Carbon::now()->format('Y-m-d').'.xlsx');
        } catch (\Exception $e) {
            echo "Có lỗi, vui lòng thử lại"; die;
        }
    }

    public function editEmail(Request $request)
    {
        $id                 = $request->id;
        $email_customer     = $request->email_customer;

        $license = License::find($id);
        $license->email_customer = $email_customer;
        $license->save();

        return response()->json(['success' => true]);
    }

    public function editName(Request $request)
    {
        $id                 = $request->id;
        $customer_name     = $request->customer_name;

        $license = License::find($id);
        $license->customer_name = $customer_name;
        $license->save();

        return response()->json(['success' => true]);
    }

    public function editPhone(Request $request)
    {
        $id                 = $request->id;
        $customer_phone     = $request->customer_phone;

        $license = License::find($id);
        $license->customer_phone = $customer_phone;
        $license->save();

        return response()->json(['success' => true]);
    }
}