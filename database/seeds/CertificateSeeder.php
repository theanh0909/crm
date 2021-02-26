<?php

use Illuminate\Database\Seeder;
use App\Models\Certificate;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataSeed = [
            [
                'code'=> '1',
                'certificate_number'=> '',
                'full_name'=> 'Nguyễn Trọng Chính',
                'birthday'=> '1997-09-20',
                'address'=> 'tp Bắc Ninh, tỉnh Bắc Ninh',
                'identify_number'=> '031084003338',
                'phone'=> '0963108271',
                'email'=> 'chinh20091997@gmail.com',
                'major'=> 'Kỹ sư Xây dựng Thủy lợi - Thủy điện',
                'proffessional'=> 'Thiết kế kết cấu công trình dân dụng - công nghiệp',
                'level'=> 'II',
                'province_code'=> 'HNT',
                'experience'=> '10',
                'company'=> 'Công ty Cổ phần Kiến trúc Xây dựng Nhà Xanh',
                'identify_date'=> '2015-10-23',
                'indentify_place'=> 'Cục cảnh sát ĐKQL cư trú và DLQG về dân cư',
                'nation'=> 'Việt Nam',
                'form_of_training'=> 'Chính quy',
                'facility'=> 'Đại học Xây dựng',

            ]
        ];
        Certificate::insert($dataSeed);
    }
}
