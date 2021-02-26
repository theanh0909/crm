<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public $table = 'product_type';

    protected $fillable = [
        'name',
    ];
}
