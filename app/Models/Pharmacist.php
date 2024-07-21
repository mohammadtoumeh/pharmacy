<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacist extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'location'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     *
     * RELATION
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritMedicines()
    {
        return $this->belongsToMany(Medicine::class, 'favorit_medicines');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
