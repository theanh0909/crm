<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    public $table = 'permission_user';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'permission_id', 'user_type'
    ];
}
