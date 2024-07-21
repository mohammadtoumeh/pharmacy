<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'commercial_name',
        'scientific_name',
        'factory_name',
        'quantity',
        'price',
        'photo'
    ];

    protected $hidden = [
        'quantity',
        'created_at',
        'updated_at'
    ];

    /**
     *
     * RELATIONS
     *
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'medicines_has_categories');
    }

    public function statusMedicine()
    {
        return $this->hasMany(StatusMedicine::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
