<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    protected $table = 'clients';

    use HasApiTokens, HasFactory, Notifiable;

    
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'birth',
        'tel_num',
        'cep',
        'state',
        'city',
    ];

    
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

  
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    // protected $attributes = [
    //     'password' => ''
    // ];

}
