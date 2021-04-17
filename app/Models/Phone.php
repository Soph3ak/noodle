<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'shop_id',
    ];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
