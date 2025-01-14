<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = ['name', 'customer_id', 'area_id', 'description', 'address', 'city', 'type', 'sale_type', 'mq', 'cover_image', 'price', 'number_bathrooms', 'number_rooms', 'elevator', 'garden', 'parking_space', 'balcony', 'energetic_effigency'];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }
}
