<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    const API_SUCCESS           = 10;
    const API_ERROR_KEY         = 11;
    const API_ERROR_OUTOF       = 12;
    const API_ERROR_UNKNOW      = 13;
    const API_ERROR_PRODUCT     = 14;

    public static $apiStatus = [
            self::API_SUCCESS       => 'Thành công',
            self::API_ERROR_KEY     => 'Mã API KEY không đúng',
            self::API_ERROR_OUTOF   => 'Số lượng Key không đủ',
            self::API_ERROR_UNKNOW  => 'Lỗi không xác định',
            self::API_ERROR_PRODUCT => 'Không tìm thấy sản phẩm',
        ];

    public $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
    ];

    protected $casts = [
        'value' => 'object'
    ];

    public static function getArrayTypes() {
        return [
            'mail_after_register_commercial'    => 'Email bản thương mại sau khi kích hoạt',
            'mail_after_register_trial'         => 'Email bản dùng thử sau khi kích hoạt',
            'mail_renewed_key_success'          => 'Email gia hạn thành công',
            'mail_remake_key_success'           => 'Email đặt lại HardwareID thành công',
            'mail_auto_before_0day'             => 'Email gửi tự động 0 ngày trước hạn',
            'mail_auto_before_3day'             => 'Email gửi tự động 3 ngày trước hạn',
            'mail_auto_before_7day'             => 'Email gửi tự động 7 ngày trước hạn',
            'mail_auto_before_10day'            => 'Email gửi tự động 10 ngày trước hạn',
            'mail_auto_before_15day'            => 'Email gửi tự động 15 ngày trước hạn',
            'mail_auto_before_30day'            => 'Email gửi tự động 30 ngày trước hạn',
        ];
    }

}
