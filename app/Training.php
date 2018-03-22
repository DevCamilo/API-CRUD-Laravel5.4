<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Training extends Authenticatable
{
    use Notifiable;
    protected $table = "training";
    public $timestamps = false;
    protected $primaryKey = "id_training";

    protected $visible = [
        'training_name', 
        'training_description', 
        'training_status', 
        'id_training_group',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'training_name', 
        'training_description', 
        'training_status', 
        'id_training_group',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'training_name',
    ];
}
