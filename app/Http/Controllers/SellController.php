<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class SellController extends Controller
{
    public function loadCategoriesSell(){
        return $categories = Category::all();
    }

    public function loadAllProducts(){
        return $products = Product::all();
    }

    public function loadProductsByCategory($id){
        $products = Category::find($id)->products;
        return $cols = collect($products);
    }

}
