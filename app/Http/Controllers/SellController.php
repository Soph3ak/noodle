<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use http\Env\Request;
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
        return view('sell', ['user'=>array($user)]);
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
        return collect($products);

    }

}
