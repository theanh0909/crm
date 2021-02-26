<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    const STATUS_TRIAL = 0;
    const STATUS_COMMERCIAL = 1;

    const KEY_ACTIVE = 1;
    const KEY_NOT_ACTIVE = 0;

    //Exported status
    const EP_FREE = 0;
    const EP_EXPORT_EXCEL = 1;
    const EP_EXPORT_API = 2;
    const EP_EXPORT_EMAIL = 3;
    const EP_EXPORT_DONATE = 4;

    public $table = 'license';

    const LC_FREE = 0;
    const LC_SENDED_EMAIL = 1;
    const LC_EXPORT_EXCEL = 2;
    const LC_EXPORT_API = 3;
    const LC_EXPORT_DONATE = 4;

    protected $fillable = [
        'license_serial',
        'license_key',
        'license_is_registered',
        'license_created_date',
        'type_expire_date',
        'hardware_id',
        'license_no_instance',
        'license_no_computers',
        'product_type',
        'created_by',
        'status',
        'status_register',
        'email_customer',
        'customer_id',
        'sell_date',
        'status_sell',
        'status_email',
        'used',
        'id_user',
        'exported',
        'exported_status',
        'domain',
        'customer_name',
        'customer_phone',
    ];

    /*
     * Status: 0 => Key dùng thử, 1 => key thương mại
     */

    public function customer() {
        return $this->belongsTo(Registered::class, 'license_serial', 'license_serial');
    }


    // 1 khóa có thể có 1 người đăng ký bên bảng registered
    public function registered()
    {
        return $this->hasOne(Registered::class, 'license_original', 'license_key');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_type', 'product_type');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function scopeNeverregister() {
        return $this->where('license_is_registered', 0)
            ->where('license_no_computers', 1)
            ->whereNull('email_customer')
            ->where('status_register', 0)
            ->where('status_email', 0)
            ->where('exported', 0)
            ->where('exported_status', 0)
            ->where('hardware_id', 'NA');
    }

    public static function getLicenseFree($status, $productType, $qty = 1, $date = '365') {
        return License::where('status', $status)
            ->where('product_type', $productType)
            ->where('license_is_registered', 0)
            ->whereNull('email_customer')
            ->where('status_register', 0)
            ->where('status_email', 0)
            ->where('exported', 0)
            ->where('exported_status', 0)
            ->where('hardware_id', 'NA')
            ->where('type_expire_date', $date)
            ->limit($qty)->get();
        
            //->where('license_no_computers', 1) // số lượng máy tính cần dk dùng
            
    }

    public function transaction() {
        return $this->hasOne(Transaction::class, 'license_id', 'id');
    }
}
