<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Captcha extends Model
{
    public $table = 'captcha';
    protected $fillable = [
        'ip_address', 'captcha_text'
    ];
}
