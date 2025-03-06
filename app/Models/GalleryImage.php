<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['estate_id', 'path'];

    public function estate(){
        return $this->belongsTo(Estate::class);
    }
}
