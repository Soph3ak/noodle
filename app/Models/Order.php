<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'table_id',
        'shop_id',
        'payment_id',
        'subtotal',
        'discount',
        'total',
    ];

    public function products()
    {
        //return $this->belongsToMany(
        //RelatedModel,
        // pivot_table_name,
        // foreign_key_of_current_model_in_pivot_table,
        // foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Product::class,
            'order_product',
            'order_id',
            'product_id')->withPivot('quantity');


    }



    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
