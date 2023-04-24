<?php

namespace App\Models;

use App\Services\Roles\RoleService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Authenticatable
{
    protected $table = 'clientes';

    use HasApiTokens, HasFactory, Notifiable;

    
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

  
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $attributes = [
        'password' => ''
    ];

    protected $appends = [
        'listOfRoles'
    ];

    public function hasRole($name)
    {
        $role = $this->roles()->where('name', $name)->first();
        return isset($role);
    }

    function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function getListOfRolesAttribute(): array
    {
        return RoleService::listOfRoles();
    }
}
