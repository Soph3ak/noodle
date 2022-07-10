<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    /*protected $table = customers;*/
    protected $fillable = [
        'name',
        'gender',
        'phone',
        'address',
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function latestOrder()
    {
        //to get latest order of customer
        return $this->hasOne(Order::class)->latestOfMany('created_at');


    }
}
