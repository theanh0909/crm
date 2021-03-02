<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sale_details';

    protected $fillable = [
        "transaction_id",
        "sale_id",
        "product",
        "product_type",
        "qty",
        "price",
        "number_day",
        "key_type",
        "discount",
        "method",
        "donate_key",
        "donate_product"
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
