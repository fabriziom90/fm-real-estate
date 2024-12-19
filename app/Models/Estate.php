<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = ['name', 'customer_id', 'area_id', 'description', 'address', 'city', 'type', 'salte_type', 'mq', 'cover_image', 'price', 'number_bathrooms', 'number_rooms', 'elevator', 'garden', 'parking_space', 'balcony', 'energetic_effigency'];
}
