<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    public $table = 'permission_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function permissions() {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }
}
