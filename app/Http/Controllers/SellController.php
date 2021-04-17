<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SellController extends Controller
{
    public function loadCategoriesSell(){
        return $categories = Category::all();
    }


    public function loadProductsByCategory($id){
        return $products = Category::find($id)->products;
    }
}
