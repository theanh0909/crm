<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NRegistered extends Model
{
    public $table = 'n_registered';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_type',
        'email',
        'tel',
        'name',
        'address',
        'note',
        'support',
        'date1',
        'key1',
        'customer_cty',
        'hardware_id',
        'key',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_type', 'product_type');
    }
}
