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

    public function loadProductsByCategory($id){
        $products = Category::find($id)->products;
        $cols = collect($products);
        /*$cols = $cols->each(function ($item, $key) {
            $item->id+=1;
        });*/
        return $cols;


    }
}
