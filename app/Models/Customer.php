<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'surname', 'email', 'phone', 'address'];

    public function purchase_proposals(){
        return $this->hasMany(PurchaseProposal::class);
    }
}
