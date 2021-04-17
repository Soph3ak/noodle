<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'name_kh',
        'price',
        'photo',
        'description',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function orders()
    {
        //return $this->belongsToMany(RelatedModel,
        //pivot_table_name,
        // foreign_key_of_current_model_in_pivot_table,
        // foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Order::class,
            'order_product',
            'product_id',
            'order_id');
    }
}
