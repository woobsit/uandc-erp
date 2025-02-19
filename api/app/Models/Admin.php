<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Admin extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
   

    protected $fillable = [
        'firstname',
        'surname',
        'email',
        'password',
        'phone',
        'gender',
        'address',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
