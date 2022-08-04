<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('product');
    }

    public function getProduct()
    {
        return $products = Product::with('category:id,name_kh') /*category is function's name in Product modal*/
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function getTopSellingProducts(){
         $top_sales = DB::table('products')
            ->leftJoin('order_product','products.id','=','order_product.product_id')
            ->selectRaw('products.id, COALESCE(SUM(order_product.quantity),0) total')
            ->groupBy('products.id')
            ->orderBy('total','desc')
            ->take(5)
            ->get();
        //[
        //    {
        //        "id": 9,
        //        "total": "106"
        //    },
        //    {
        //        "id": 12,
        //        "total": "64"
        //    },
        //    {
        //        "id": 4,
        //        "total": "64"
        //    },
        //    {
        //        "id": 10,
        //        "total": "59"
        //    },
        //    {
        //        "id": 2,
        //        "total": "48"
        //    }
        //]

        $topSellingProducts = [];
        foreach ($top_sales as $ts){
            $p = Product::findOrFail($ts->id);
            $p->totalSold = $ts->total;

            $topSellingProducts[] = $p;
        }
        return $topSellingProducts;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'name_kh' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'pro_discount' => ['nullable', 'numeric'],
            'photo' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable','string', 'max:255'],
            'category_id' => ['required','numeric'],

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return void
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Product $product)
    {
        $this->validator($request->all())->validate();
        $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return void
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
