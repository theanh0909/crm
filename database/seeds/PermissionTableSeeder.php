<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataSeed = [

            'Key' => [
                'license-sendkey'       => 'Gửi Key đến khách hàng',
                'license-index'         => 'Xem danh sách',
                'license-create'        => 'Tạo key mới',
                'license-edit'          => 'Chỉnh sửa key',
                'license-export'        => 'Export Excel',
                'license-edit-email'    => 'Sửa Email khách hàng',
                'license-block'         => 'Khóa Key',
            ],

            'Sản phẩm' => [
                'product-index'     => 'Xem danh sách sản phẩm',
                'product-create'    => 'Tạo mới sản phẩm',
                'product-edit'      => 'Sửa sản phẩm',
                'product-delete'    => 'Xóa sản phẩm',
                'product-email'     => 'Cài đặt Template Email',
            ],

            'Khách hàng' => [
                'customer-registed'         => 'Xem danh sách khách hàng',
                'customer-not-registed'     => 'Xem danh sách khách hàng chưa thanh toán',
                'customer-remake-key'       => 'Đặt lại Key',
                'customer-paid'             => 'Xác nhận thanh toán',
                'customer-edit'             => 'Sửa thông tin khách hàng',
                'customer-renewed'          => 'Gia hạn key',
            ],

            'Hệ thống' => [
                'system-email'     => 'Cài đặt Email',
                'system-system'    => 'Cài đặt hệ thống',
                'mailcontent'      => 'Cài đặt nội dung Email',
                'role-access'      => 'Thao tác phân quyền',
                'admin-user'       => 'Quản lý Users hệ thống',
                'user-cpassword'   => 'Đổi mật khẩu user',
            ],
        ];

        foreach ($dataSeed as $k1 => $seed1) {
            $idGroup = DB::table('permission_group')->insertGetID([
                'name' => $k1
            ]);
            foreach($seed1 as $kchild => $valChild) {
                DB::table('permissions')->insert([
                    'group_id'      => $idGroup,
                    'name'          => $kchild,
                    'display_name'  => $valChild
                ]);
            }
        }
    }
}
