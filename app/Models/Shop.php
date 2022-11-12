<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_kh',
        'email',
        'address',
        'address_kh'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function phones(){
        return $this->hasMany(Phone::class);
    }
}
