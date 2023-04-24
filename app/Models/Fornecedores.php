<?php

namespace App\Models;

use App\Services\Roles\RoleService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'fornecedores';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'cnpj',
        'endereco',
        'telefone',
        'cidade',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
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
