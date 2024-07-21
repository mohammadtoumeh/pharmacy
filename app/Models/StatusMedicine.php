<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'quantity',
        'expiration_date'
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
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
