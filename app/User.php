<?php

namespace App;

use App\Models\Roles;
use App\Models\RoleUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\Registered;
use App\Models\TransactionWait;

class User extends Authenticatable
{

    CONST TYPE_ADMIN = 1;
    CONST TYPE_ADMIN_USER = 2;

    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','fullname', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'user_request_id', 'id');
    }

    public function transactionWait()
    {
        return $this->hasMany(TransactionWait::class);
    }

    public function registered()
    {
        return $this->hasMany(Registered::class, 'user_support_id', 'id');
    }
}
