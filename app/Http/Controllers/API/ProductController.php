<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'name_kh' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
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

        return ['message'=>'Created successfully'];
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
        /*dd($request);*/
        $this->validator($request->all())->validate();
        $product->update($request->all());
        return response()->json($request,'200');
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
        /*return ['message'=>'Deleted success'];*/
    }
}
