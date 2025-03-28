<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseProposal extends Model
{
    protected $fillable = ['area_id', 'customer_id', 'city', 'price_from', 'price_to', 'mq_from', 'mq_to', 'type', 'sale_type', 'elevator', 'garden', 'parking_space', 'balcony', 'energetic_efficency', 'number_rooms', 'number_bathrooms', 'notes'];

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
