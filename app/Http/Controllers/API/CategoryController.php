<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'name_kh' => ['required', 'string', 'max:255'],
            'description' => ['nullable','string', 'max:255'],
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $categories = Category::orderBy('id', 'desc')->paginate(5);
    }

    public function getCategoriesSelect2()
    {
        return $categories = Category::select('id', 'name_kh as text')
            ->orderBy('id','desc')
            ->get();

        /*return ['message'=>'getCategories for select2 successfully'];*/
    }

    /*public function getCategoriesSell()
    {
        return $categories = Category::select('id', 'name_kh as text')
            ->orderBy('id','desc')
            ->get();

    }*/

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
        Category::create($request->all());


        /*return ['message'=>'Created successfully'];*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $this->validator($request->all())->validate();
        $category->update($request->all());
        return ['message'=>"Updated success"];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return void
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        /*$category->delete();*/
        return ['message'=>'Deleted success'];
    }
}
