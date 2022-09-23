<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'users';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
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
        return Array(
            self::addListRole('admin', 'Adminstrador'),
            self::addListRole('opt1', 'Opção1'),
            self::addListRole('opt2', 'opção2')
        );
    }

    private static function addListRole($id, $name): array {
        return [
            'id' => $id,
            'name' => $name
        ];
    }
}
