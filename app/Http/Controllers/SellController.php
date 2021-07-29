<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{

    public function index(){
        return view('sell');
    }

    public function loadUser(){
        if(Auth::check()){
            return $user = Auth::user();
        }
        else return "No";
    }

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
