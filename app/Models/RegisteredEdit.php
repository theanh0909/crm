<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisteredEdit extends Model
{
    protected $table = 'registered_edits';

    protected $fillable = [
        'registered_id', 'license_id', 'status', 'type_key'
    ];

    public function registered()
    {
        return $this->belongsTo(Registered::class, 'registered_id', 'id');
    }

    public function license()
    {
        return $this->belongsTo(License::class, 'license_id', 'id');
    }
}
