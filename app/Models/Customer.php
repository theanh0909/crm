<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $table = 'customers';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'birthday',
        'company',
        'school',
        'nation',
        'id_card',
        'date_card',
        'qualification',
        'address_card', 
        'city',
        'exper_num',
        'edu_system'
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
