<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public $table = 'feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'title', 'content', 'status',
    ];

    public function customer() {
        return $this->belongsTo(Registered::class, 'customer_id', 'id');
    }
}
