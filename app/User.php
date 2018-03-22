<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    use Notifiable;
    protected $table = "user";
    public $timestamps = false;
    protected $primaryKey = "id_user";

    protected $visible = [
        'id_user',
        'user_name',
        'user_lastName',
        'date_created',
        'date_update',
        'id_role',
        'status',
        'user_password',
        'user_email',
        'user_nickName',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'user_name',
        'user_lastName',
        'date_created',
        'date_update',
        'id_role',
        'status',
        'user_password',
        'user_email',
        'user_nickName',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
    ];
}
