<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
      'warehouse_id',
      'pharmacist_id'
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
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'orders_has_medicines')->withPivot('quantity');
    }

}
