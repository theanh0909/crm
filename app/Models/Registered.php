<?php

namespace App\Models;

use App\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Registered extends Model
{
    public $table = 'registered';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'license_serial',
        'license_original',
        'hardware_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'license_activation_date',
        'last_runing_date',
        'license_expire_date',
        'product_type',
        'customer_cty',
        'user_agent',
        'attribute',
        'point',
        'user_support_id',
        'status_mail',
        'status',
        'status_care',
        'type_expire_date',
        'number_can_change_key',
        'number_has_change_key',
        'background',
        'note',
        'qty',
        'option',
        'price',
        'discount',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_type', 'product_type');
    }

    public function license() {
        return $this->hasOne(License::class, 'license_serial', 'license_serial');
    }

    // 1 khóa đã dk ng đăng ký nằm trong bảng License
    public function licenseUpdate()
    {
        return $this->belongsTo(License::class, 'license_key', 'license_serial');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_support_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_email', 'email');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
