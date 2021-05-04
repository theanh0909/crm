<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransactionWait;
use App\Models\Registered;
use App\Models\CronjobMail;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function certificateForm ($id)
    {
        return view('client.certificate_form', compact('id'));
    }

    public function addCertificate(Request $request, $id)
    {
            $this->validate($request, [
                'customer_name' => 'required',
                'customer_birthday' => 'required',
                'customer_address' => 'required',
                'nation' => 'required',
                'customer_phone' => 'required|min:10',
                'customer_email' => 'required|email',
                'id_card' => 'required',
                'date_card' => 'required',
                'address_card' => 'required',
                'qualification' => 'required',
                'school' => 'required',
                'edu_system' => 'required',
                'type_exam' => 'required',
                'class' => 'required',
                'exper_num' => 'required',
                'company' => 'required',
                'customer_cty' => 'required',
            ],[
                'customer_name.required' => '* Cần điền họ và tên',
                'customer_birthday.required' => '* Cần điền ngày sinh',
                'customer_address.required' => '* Cần điền địa chỉ thường trú',
                'nation.required' => '* Cần điền quốc tịch',
                'customer_phone.required' => '* Cần điền số điện thoại',
                'customer_phone.min' => '* Số điện thoại ít nhất phải 10 số',
                'customer_email.required' => '* Cần điền địa chỉ email',
                'customer_email.email' => '* Địa chỉ Email không đúng định dạng',
                'id_card.required' => '* Cần điền số CMT hoặc hộ chiếu',
                'date_card.required' => '* Cần điền ngày cấp CMT, hộ chiếu',
                'address_card.required' => '* Cần điền địa chỉ cấp CMT, hộ chiếu',
                'qualification.required' => '* Cần điền trình độ chuyên môn',
                'school.required' => '* Cần điền cơ sở đào tạo',
                'edu_system.required' => '* Cần điền hệ đào tạo',
                'type_exam.required' => '* Cần điền lĩnh vực đăng ký sát hạch',
                'class.required' => '* Cần điền hạng sát hạchh',
                'exper_num.required' => '* Cần điền số năm kinh nghiệm',
                'company.required' => '* Cần điền đơn vị công tác',
                'customer_cty.required' => '* Cần điền địa chỉ nơi thi',
            ]);
            $nameUpload = $request->customer_name . ' ' . rand();
            $data = $request->all();
            $data['name_upload'] = $nameUpload;
            $data['slug'] = str_slug($nameUpload);
            $data['user_id'] = $id;
            $data['product_type'] = 'hnt'; // mặc định, sau đó nv sẽ sửa lại
            $data['type_exam'] = str_replace(',', ';', $request->type_exam);
            $data['class'] = rtrim($request->class, ';');
            TransactionWait::create($data);
    
            return back()->withInput()->with('success', 'Gửi thông tin thành công');
        
    }

    public function autoSendMail(Request $request)
    {
        $type = $request->type;
        $day = $request->day;
        $dateNow = date('Y-m-d');
        $mailModel = CronjobMail::where('type', $type)->first();

        if ($type == 'expire') {
            $dateExpire = date('Y-m-d', strtotime($dateNow . " - $day days"));
            $between = [$dateExpire, $dateNow];
        } else if ($type == 'due') {
            $dateDue = date('Y-m-d', strtotime($dateNow. " + $day days"));
            $between = [$dateNow, $dateDue];
        }
        $customers = Registered::whereBetween('license_expire_date', $between)
                                ->where('status_mail', 0) // những email chưa gửi
                                ->select('status_mail', 'license_expire_date', 'customer_email', 'product_type', 'customer_name')
                                ->get();

        foreach ($customers as $customer) {
            $name = $customer->customer_name;
            $customerEmail = $customer->customer_email;
            $product = $customer->product->name;
            Mail::send([], [], function($message) use ($mailModel, $name, $customerEmail, $product) {
                $subject = str_replace("[name]", $name, $mailModel->email->subject);
                $subject = str_replace("[product]", $product, $subject);
                $body    = str_replace("[name]", $name, $mailModel->email->content);
                $body    = str_replace("[product]",  $product, $body);
                $message->to($customerEmail)
                    ->subject($subject)
                    ->setBody($body, 'text/html');
            });
        }
    }
}
