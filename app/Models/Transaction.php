<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const STATUS_PENDDING       = 0;
    const STATUS_APPROVE        = 1;
    const STATUS_REJECT         = 2;


    public $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_request_id',
        'user_approve_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_birthday',
        'customer_cty',
        'product_type',
        'time_request',
        'time_approve',
        'status',
        'note',
        'number_day',
        'qty',
        'type',
        'customer_type',
        'price',
        'discount',
        'option',
        'license_original',
        'free',
        'donate_key',
        'donate_product',
        'license_id',
        'status_exam',
        'date_exam',
        'certificate_code',
        'id_card',
        'date_card',
        'address_card',
        'qualification',
        'type_exam',
        'class',
        'province_code',
        'exper_num',
        'company',
        'nation',
        'edu_system',
        'school',
        'collaborator',
        'name_upload',
        'decree',
        'retest',
        'status_certificate',
        'status_salary'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_request_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_type', 'product_type');
    }

    public function license() {
        return $this->belongsTo(License::class, 'license_id', 'id');
    }

    public function donateproduct() {
        return $this->belongsTo(Product::class, 'donate_product', 'product_type');
    }

    public function registered() {
        return $this->hasOne(Registered::class, 'transaction_id', 'id');
    }
}
