<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'employee_name',
        'salary',
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

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

}
