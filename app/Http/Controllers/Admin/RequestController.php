<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailKey;
use App\Models\Email;
use App\Models\License;
use App\Models\Product;
use App\Models\Registered;
use App\Models\Transaction;
use App\Models\Customer;
use App\Permission;
use App\Role;
use App\Services\Production\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RequestController extends Controller
{
    public function index()
    {
        $datas = Transaction::where('status', 0)
                ->has('product')->has('user')
                ->with(['product', 'user', 'donateproduct'])
                ->orderBy('id', 'DESC')
                ->paginate(20);

        return view('admin.request.index', compact(
            'datas'
        ));
    }

    public function print($transactionId) {
        $data = Transaction::findOrFail($transactionId);

        return view('admin.request.print', ['transaction' => $data]);
    }

    public function create()
    {
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

        return view('admin.request.create', compact('products', 'typeExpireDate'));
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $inputs['user_request_id'] = auth()->user()->id;

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
        $customer = Customer::updateOrCreate(
            [
                "email" => $inputs['customer_email'],
                
            ],[
                "name" => $inputs['customer_name'],
                "phone" => $inputs['customer_phone'],
            ]
        );
        $inputs['customer_id'] = $customer->id;
        Transaction::create($inputs);

        return redirect()->route('admin.request.myRequest');
    }

    public function approve(Request $request)
    {
        $id     = $request->id;
        $data   = Transaction::find($id);

        if($data->customer_type == 0) {
            $result = $this->_approveSoftware($data);
        }
        if($data->customer_type == 1) {
            $result = $this->_approveHashware($data);
        }
        if($data->customer_type == 2) {
            $result = $this->_approveCourse($data);
        }
        if ($data->customer_type == 3) {
            $result = $this->_approveCertificate($data);
        }
        return $result;
    }

    public function _approveCertificate($data)
    {
        Registered::create([
            'customer_name' => $data->customer->name,
            'customer_email'    => $data->customer->email,
            'customer_phone'    => $data->customer->phone,
            'qty'               => $data->qty,
            'price'             => $data->price,
            'license_original'  => $data->license_original,
            'hardware_id'       => 'CHUNGCHI',
            'product_type'      => $data->product_type,
            'customer_address'  => $data->customer->address,
            'customer_cty'      => $data->customer->city,
            'user_support_id'   => $data->user_request_id,
            'transaction_id'    => $data->id,
        ]);
        $data->status           = Transaction::STATUS_APPROVE;
        $data->time_approve     = Carbon::now()->format('Y-m-d H:i:s');
        $data->user_approve_id  = auth()->user()->id;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Duyệt thành công'
        ]);
    }

    public function _approveHashware($data) {
        Registered::create([
            'customer_name' => $data->customer->name,
            'customer_email'    => $data->customer->email,
            'customer_phone'    => $data->customer->phone,
            'qty'               => $data->qty,
            'price'             => $data->price,
            'license_original'  => $data->license_original,
            'hardware_id'       => 'KHOACUNG',
            'product_type'      => $data->product_type,
            'customer_address'  => $data->customer->address,
            'customer_cty'      => $data->customer->city,
            'user_support_id'   => $data->user_request_id,
            'transaction_id'    => $data->id,
        ]);

        $email          = Email::where('product_type', $data->product_type)->first();
        $userCreate     = $data->user;

        if($email) {
            MailService::sendEmailProduct($email, $data->customer->email, $data->customer->name, $data->license_original, 1);
            MailService::sendEmailProduct($email, $userCreate->email, $data->customer->name, $data->license_original, 1);
        }

        $data->status           = Transaction::STATUS_APPROVE;
        $data->time_approve     = Carbon::now()->format('Y-m-d H:i:s');
        $data->user_approve_id  = auth()->user()->id;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Duyệt thành công'
        ]);
    }

    public function _approveCourse($data) {
        Registered::create([
            'customer_name'     => $data->customer->name,
            'customer_email'    => $data->customer->email,
            'customer_phone'    => $data->customer->phone,
            'qty'               => $data->qty,
            'price'             => $data->price,
            'license_original'  => $data->license_original,
            'hardware_id'       => 'KHOAHOC',
            'product_type'      => $data->product_type,
            'customer_address'  => $data->customer->address,
            'customer_cty'      => $data->customer->city,
            'user_support_id'   => $data->user_request_id,
            'option'            => $data->option,
            'transaction_id'    => $data->id,
        ]);

        $userCreate     = $data->user;

        if ($data->donate_key == 1) {
            $licenses = License::getLicenseFree(2, $data->donate_product, 1, '365');

            if (count($licenses) == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có key phần mềm tặng kèm để gửi'
                ]);
            }

            foreach ($licenses as $license) {
                $emailDonate   = Email::where('product_type', $license->product_type)->first();

                if ($emailDonate) {
                    $email = Email::where('product_type', $license->product_type)->first();

                    MailService::sendEmailProduct($email, $data->customer->email, $data->customer->name,$licenses[0]->license_key, 1);

                    MailService::sendEmailProduct($email, $userCreate->email, $data->customer->name,$licenses[0]->license_key, 1);

                    License::where('license_key', $licenses[0]->license_key)->update(
                        [
                            'status_register' => 1,
                            'status_email' => 1,
                            'email_customer' => $data->customer->email,
                            'sell_date' => date('Y-m-d'),
                            'status_sell' => 1,
                            'exported_status' => License::EP_EXPORT_EMAIL,
                            'id_user' => $data->user_request_id
                        ]
                    );
            /*code cũ của Hợi
                    dispatch(new SendEmailKey(
                        $license->product_type,
                        $data->customer_email,
                        $data->customer_name,
                        $license->license_original,
                        1,
                        $userCreate->email
                    ));
            */
                }

                $license->exported_status   = License::EP_EXPORT_DONATE;
                $license->save();

                $data->license_id = $license->id;
            }
        };

        $email          = Email::where('product_type', $data->donate_product)->first();
    // check gửi mail
        if ($email) {
            dispatch(new SendEmailKey(
                $data->donate_product,
                $data->customer->email,
                $data->customer->name,
                $data->license_original,
                1,
                $userCreate->email
            ));
        } 

        $data->status           = Transaction::STATUS_APPROVE;
        $data->time_approve     = Carbon::now()->format('Y-m-d H:i:s');
        $data->user_approve_id  = auth()->user()->id;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Duyệt thành công'
        ]);
    }

    public function _approveSoftware($data)
    {
        $qty                = $data->qty;
        $customer_email     = $data->customer->email;
        $userCreate         = $data->user;

        $query = License::where('product_type', $data->product_type)
                        ->where('license_is_registered', 0) // 
                        ->where('status', $data->type) // key thương mại = 0; key thử nghiệm = 1
                        ->where('type_expire_date', $data->number_day) // số lượng ngày sử dụng key
                        ->whereNull('email_customer') // key này chưa có email nào nhận
                        ->where('status_email', 0) // chưa gửi email
                        ->where('exported', 0); // chưa xuất ra ngoài
                        //->where('license_no_computers', 1) // số lượng máy tính cần dk dùng
                        

        if($query->count() < $qty) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng KEY không đủ'
            ]);
        }
        $email = Email::where('product_type', $data->product_type)->first();

        if(!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm chưa có template cho email, vui lòng setup!'
            ]);
        }

        $licenses = $query->limit($qty)->get();
        try {
            for ($i = 0; $i < $qty; $i++) {

                $license = $licenses[$i];
                $license->status_register   = 1;
                $license->status_email      = 1;
                $license->email_customer    = $customer_email;
                $license->sell_date         = Carbon::now()->format('Y-m-d');
                $license->status_sell       = 1;
                $license->exported_status   = License::EP_EXPORT_EMAIL;
                $license->id_user           = $data->user_request_id;
                $license->save();
                // SEND MAIL
                MailService::sendEmailProduct($email, $customer_email, $data->customer->name, $license->license_key, $license->status);
                MailService::sendEmailProduct($email, $userCreate->email, $data->customer->name, $license->license_key, $license->status);
            }
            $data->status           = Transaction::STATUS_APPROVE;
            $data->time_approve     = Carbon::now()->format('Y-m-d H:i:s');
            $data->user_approve_id  = auth()->user()->id;
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Duyệt thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => 'Có lỗi, vui lòng thử lại'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $id     = $request->id;
        $data   = Transaction::find($id);
        
        if ($data) {
            $data->delete();
        }

        return back()->with('success', 'Xóa thành công');
    }

    public function myRequest(Request $request)
    {
        $id = auth()->user()->id;
        $datas = Transaction::where('user_request_id', $id)
                ->has('product')->orderBy('id', 'DESC')
                ->with(['product', 'user'])
                ->paginate(20);

        return view('admin.request.my_request', compact(
            'datas'
        ));
    }

    public function approveAll($type)
    {
        if($type == 0) {
            $result = $this->_approveAllSoftware();
        }
        if($type == 1) {
            $result = $this->_approveAllHardware();
        }
        if($type == 2) {
            $result = $this->_approveAllCourse();
        }

        return redirect()->back()->with([
            'success' => "Duyệt thành công"
        ]);
    }

    public function _approveAllSoftware()
    {
        $datas = Transaction::where('status', 0)->where('customer_type', 0)->get();
        
        foreach($datas as $data) {
            $qty                = $data->qty;
            $customer_email     = $data->customer_email;
            $userCreate         = $data->user;

            $query = License::where('product_type', $data->product_type)
                ->where('license_is_registered', 0)
                ->where('status', $data->type)
                ->where('type_expire_date', $data->number_day)
                ->where('license_no_computers', 1)
                ->whereNull('email_customer')
                ->where('status_email', 0)
                ->where('exported', 0);

            if($query->count() >= $qty) {
                $email = Email::where('product_type', $data->product_type)->first();
                if(!$email) {
                    continue;
                }

                $licenses = $query->limit($qty)->get();
                for ($i = 0; $i < $qty; $i++) {
                    $license = $licenses[$i];
                    $license->status_register   = 1;
                    $license->status_email      = 1;
                    $license->email_customer    = $customer_email;
                    $license->sell_date         = Carbon::now()->format('Y-m-d');
                    $license->status_sell       = 1;
                    $license->exported_status   = License::EP_EXPORT_EMAIL;
                    $license->id_user           = $data->user_request_id;
                    $license->save();
                    // SEND MAIL

                    MailService::sendEmailProduct($email, $customer_email, $data->customer_name, $license->license_key, $license->status);
                    MailService::sendEmailProduct($email, $userCreate->email, $data->customer_name, $license->license_key, $license->status);

                }

                $data->status           = Transaction::STATUS_APPROVE;
                $data->time_approve     = Carbon::now()->format('Y-m-d H:i:s');
                $data->user_approve_id  = auth()->user()->id;
                $data->save();
            }
        }

        return true;
    }

    public function _approveAllHardware()
    {
        $datas = Transaction::where('status', 0)->where('customer_type', 1)->get();
        foreach($datas as $data) {
            $email = Email::where('product_type', $data->product_type)->first();
            if(!$email) {
                continue;
            }

            Registered::create([
                'customer_name' => $data->customer_name,
                'customer_email'    => $data->customer_email,
                'customer_phone'    => $data->customer_phone,
                'qty'               => $data->qty,
                'price'             => $data->price,
                'license_original'  => $data->license_original,
                'hardware_id'       => 'KHOACUNG',
                'product_type'      => $data->product_type,
                'customer_address'  => $data->customer_address,
                'customer_cty'      => $data->customer_cty,
                'user_support_id'   => $data->user_request_id,
            ]);

            $userCreate     = $data->user;

            MailService::sendEmailProduct($email, $data->customer->email, $data->customer->name, $data->license_original, 1);
            MailService::sendEmailProduct($email, $userCreate->email, $data->customer->name, $data->license_original, 1);

            $data->status           = Transaction::STATUS_APPROVE;
            $data->time_approve     = Carbon::now()->format('Y-m-d H:i:s');
            $data->user_approve_id  = auth()->user()->id;
            $data->save();

            return true;
        }
    }

    public function _approveAllCourse()
    {
        $datas = Transaction::where('status', 0)->where('customer_type', 2)->get();
        foreach($datas as $data) {
            $email = Email::where('product_type', $data->product_type)->first();
            if(!$email) {
                continue;
            }

            $this->_approveCourse($data);
        }
        return true;
    }

    public function edit($id)
    {
        $model = Transaction::find($id);

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

        return view('admin.request.edit', compact('model', 'products', 'typeExpireDate'));
    }

    public function update($id, Request $request) {
        $inputs = $request->all();

        if(isset($inputs['type']) && $inputs['type'] == 0 && $inputs['customer_type'] == 0) {
            $email = Email::where('product_type', $inputs['product_type'])->first();
            if(!$email) {
                return redirect()->back()->with([
                    'error' => 'Sản phẩm chưa có template cho email, vui lòng setup!'
                ]);
            }

            $query = License::where('product_type', $inputs['product_type'])
                ->where('license_is_registered', 0)
                ->where('status', 0)
                ->where('type_expire_date', $inputs['number_day'])
                ->where('license_no_computers', 1)
                ->whereNull('email_customer')
                ->where('status_email', 0)
                ->where('exported', 0);

            if($query->count() < $inputs['qty']) {
                return redirect()->back()->with([
                    'error' => 'Số lượng KEY không đủ'
                ]);
            }

            $licenses = $query->limit($inputs['qty'])->get();
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

        unset($inputs['_token'], $inputs['_method']);
        Transaction::where('id', $id)->update($inputs);

        return redirect()->route('admin.request.myRequest')->with([
            'success' => 'Update thành công!'
        ]);
    }

    public function delete($id)
    {
        Transaction::where('id', $id)->delete();

        return redirect()->route('admin.request.myRequest')->with([
            'success' => 'Xóa thành công!'
        ]);
    }
}