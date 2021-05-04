<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronjobMail extends Model
{
    //
    protected $table = 'cronjob_mails';

    protected $fillable = ['email_id', 'type'];

    public function email()
    {
        return $this->belongsTo(Email::class, 'email_id', 'id');
    }
}
