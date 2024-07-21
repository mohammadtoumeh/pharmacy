<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_name',
        'description',
        'location'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     *
     * RELATIONS
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function states()
    {
        return $this->belongsToMany(State::class, 'warehouses_has_states');
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
