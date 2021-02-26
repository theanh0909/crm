<?php

namespace App\Models;

use App\Models\Scope\ProductScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    const TYPE_SOFWTWARE = 0;
    const TYPE_HARDWARE  = 1;
    const TYPE_COURSE    = 2;
    const TYPE_CERTIFICATE = 3;
    const TYPE_ALL = 4;


    public $table = 'product';

    public static $typeLabel = [
        self::TYPE_SOFWTWARE => 'Khóa mềm',
        self::TYPE_HARDWARE  => 'Khóa cứng',
        self::TYPE_COURSE    => 'Khóa học',
        self::TYPE_CERTIFICATE    => 'Chứng chỉ',
    ];

    protected $fillable = [
        'name',
        'icon',
        'price',
        'product_type',
        'description',
        'version',
        'key_version',
        'email',
        'number_of_change',
        'discount',
        'type',
        'status',
        'api',
        'input_price',
    ];

    public function has_email() {
        return $this->hasOne(Email::class, 'product_type', 'product_type');
    }
    
    public function license()
    {
        return $this->hasMany(License::class, 'product_type', 'product_type');
    }

     public static function boot() {
         parent::boot();

         static::addGlobalScope(new ProductScope);
     }
}
