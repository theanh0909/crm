<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        "user_id",
        "customer_name",
        "customer_email",
        "customer_phone",
        "customer_address",
        "customer_city",
        "note",
        "total",
        "prepaid",
        "status_prepaid",
        "name_upload",
        "created_at",
        "updated_at",
    ];

    public function saleDetail()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
