<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(Category::where('parent_id',0)->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create(array(
            "title" => ucwords($request->title),
            "description" => ucfirst($request->description) ?? "",
            "parent_id" => ucfirst($request->parent_id) ?? null
        ));
        return response()->json(['message' => 'Category created successfully', 'category' => $category], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->title =ucwords($request->title) ?? $category->title;
        $category->description = ucfirst($request->description) ??  $category->description;
        $category->save();
        return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
    }
    public function updateCoverPhoto(Request $request, Category $category){
        $category->file_id = $request->file_id;
        $category->save();
        return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
    #endregion
}
