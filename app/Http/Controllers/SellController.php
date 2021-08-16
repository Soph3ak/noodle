<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function __construct()
    {
        /*$this->middleware('auth');*/
        $this->middleware('auth', ['only' => ['index','loadUser']]);
    }

    public function index(){
       $user = Auth::user();
       return view('sell');
    }

    public function loadUser(){
        return $user = Auth::user();
    }

    public function loadCategoriesSell(){
        return $categories = Category::all();
    }

    public function loadAllProducts(){
        return $products = Product::all();
    }

    public function loadProductsByCategory($id){
        $products = Category::find($id)->products;
        /*$products = Product::where('category_id',$id)->get();*/ /*SAME RESULT*/
        foreach ($products as $product) {

        }
        $cols = collect($products);
        return $cols;

    }

}
