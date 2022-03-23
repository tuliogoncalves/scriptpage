<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $incrementing = true;
	public $timestamps = false;
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
