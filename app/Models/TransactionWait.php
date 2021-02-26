<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
        "customer_city",    
        "status_exam",      
        "date_exam",
        "certificate_code",
        "id_card",
        "date_card",
        "address_card",
        "qualification",
        "decree",
        "type_exam",
        "class",
        "province_code",
        "exper_num",
        "company",
        "nation",
        "edu_system",
        "school",
        "price",
        "prepaid",
        "collaborator",
        "discount",
        "note",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
