<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;


   /**
    *
    * RELATIONS
    */
   public function warehouses()
   {
       return $this->belongsToMany(Warehouse::class,'warehouses_has_states');
   }
}
