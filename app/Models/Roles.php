<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustRole;

class Roles extends LaratrustRole
{
    public $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    public function permissionRole() {
        return $this->hasMany(PermissionRole::class, 'role_id', 'id');
    }

    public function permissions() {
        return $this->hasManyThrough(
            Permission::class,
            PermissionRole::class,
            'role_id',
            'id',
            'id',
            'permission_id'
        );
    }
}
