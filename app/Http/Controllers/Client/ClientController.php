<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransactionWait;

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
}
