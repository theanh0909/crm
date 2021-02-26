<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public $table = 'certifications';
    protected $fillable = [
        'code',
        'certificate_number',
        'full_name',
        'birthday',
        'address',
        'identify_number',
        'phone',
        'email',
        'major',
        'proffessional',
        'level',
        'province_code',
        'experience',
        'company',
        'identify_date',
        'indentify_place',
        'nation',
        'form_of_training',
        'facility',
    ];
}
