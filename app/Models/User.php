<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     *  JWT
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'user_type' => $this->user_type,
            'roles' => $this->user_type === 'employee' ?
                $this->roles()->pluck('role_name')->toArray() : []
        ];
    }

    /**
     *
     * RELATIONS
     *
     */
    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function pharmacist()
    {
        return $this->hasOne(Pharmacist::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_has_roles');
    }

}
