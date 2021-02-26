<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public $fillable = ['name', 'display_name', 'description', 'group_id'];
}
