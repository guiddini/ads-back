<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoriesResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CategoriesResource::collection(
          Category::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoriesResource
     */
    public function show(Category $category)
    {
        return new CategoriesResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return CategoriesResource
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->all());

        return new CategoriesResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, 204);
    }
}
