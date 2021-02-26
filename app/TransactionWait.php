<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionWait extends Model
{
    protected $table = 'transaction_waits';
    protected $fillable = [
        "name_upload",
        "slug",
        "user_id",
        "product_type",
        "retest",
        "customer_account",
        "customer_name",
        "customer_birthday",
        "customer_address",
        "customer_phone",
        "customer_email",
        "status_exam",
        "date_exam",
        "certificate_code",
        "id_card",
        "date_card",
        "address_card",
        "qualification",
        "type_exam",
        "class",
        "province_code",
        "exper_num",
        "company",
        "nation",
        "edu_system",
        "school",
        'price',
        'prepaid',
        'discount',
        'collaborator',
        'customer_city',
        'date_exam',
        'note',
        'decree'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
