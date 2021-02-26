<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemakePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remake:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remake permission';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dataSeed = [
            'Key' => [
                'license-create'       => 'Tạo Key',
                'license-view'         => 'Xem danh sách',
                'license-sendkey'      => 'Gửi Key',
                'license-approved'     => 'Duyệt gửi Key'
            ],

            'Khách hàng' => [
                'customer-view'     => 'Xem tất cả khách hàng',
                'customer-feedback' => 'Xem feedback',
                'customer-renew'    => 'Gia hạn key',
                'customer-reset'    => 'Đặt lại Key',
                'customer-block'    => 'Khóa Key',
                'customer-delete'   => 'Xóa khách hàng',
            ],

            'Thống kê' => [
                'statistic-region'     => 'Thống kê theo khu vực',
                'statistic-user'       => 'Thống kê nhân viên',
            ],

            'Hệ thống' => [
                'system-product'            => 'Quản lý sản phẩm',
                'system-email'              => 'Cấu hình Email',
                'system-emailtemplate'      => 'Template Email',
                'system-user'               => 'Quản lý User',
                'system-system'             => 'Cài đặt hệ thống',
            ],
        ];

        \DB::table('role_user')->delete();
        \DB::table('permission_role')->delete();
        \DB::table('permission_group')->delete();
        \DB::table('permission_user')->delete();
        \DB::table('permissions')->delete();

        foreach ($dataSeed as $k1 => $seed1) {
            $idGroup = \DB::table('permission_group')->insertGetID([
                'name' => $k1
            ]);
            foreach($seed1 as $kchild => $valChild) {
                \DB::table('permissions')->insert([
                    'group_id'      => $idGroup,
                    'name'          => $kchild,
                    'display_name'  => $valChild
                ]);
            }
        }
    }
}
