<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $new_category = [
            "id" => 1,
            "title" => "New Products",
            "description" => "",
            "parent_id" => 0,
            "sub_categories" => [],
            "parent_category" => null,
            "banner_file" => [
                "id"=> 19789,
                "title"=> "New Items.jpg",
                "filename"=> "OUCsBhrnmJ5DpqPxPLXHs3TwISLJnRBQHpZD5QJ0.jpg",
                "type"=> "image\/jpeg",
                "deleted_at"=> null
            ],
            "img" => "YWAO5MIpcSyZ0TxtMXhHJiBjKpS7EqmjWbdcdkzH.jpg"
        ];
        $category = Collect([]);
        $category->push($new_category);
        
        $category = $category->merge(CategoryResource::collection(Category::where('parent_id', 0)->get()->toArray()));
        return response([
            "data" => $category
        ],200);
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
            "parent_id" => ucfirst($request->parent_id) ?? null,
        ));
        return response()->json(['message' => 'Category created successfully', 'category' => $category], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $category)
    {
        $query = Product::whereNotIn('id', $request->session()->get('restricted_products', array()))->where('created_at', '>', now()->subDays(3));

        if ((int) $category != 1) {
            $category = Category::find($category);
            $query = Product::whereNotIn('id', $request->session()->get('restricted_products', array()))->whereHas('product_categories', function ($query) use ($category) {
                if ($category->id) {
                    $query->where('product_categories.category_id', $category->id);
                }
            });
        }
        
        return new CategoryResource(Category::find($category));
        
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
        $category->title = ucwords($request->title) ?? $category->title;
        $category->description = ucfirst($request->description) ?? $category->description;
        $category->cover_html = ($request->cover_html) ?? $category->cover_html;

        $category->save();
        return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
    }

    public function updateCoverPhoto(Request $request, Category $category)
    {
        $category->file_id = $request->file_id;
        $category->save();
        return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
    }

    public function updateBannerImage(Request $request, Category $category)
    {
        $category->banner_file_id = $request->banner_file_id;
        $category->save();

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
    #endregion
    #region Custom Functions
    public static function batchUpdate(Request $request)
    {
        // return response()->noContent(200);

        // foreach ($request->categories as $key => $curData) {
        $curData = $request->categories;
        $allowContinue = [
            array_key_exists('data', $curData),
            array_key_exists('remove', $curData),
            array_key_exists('append', $curData),
        ];
        if (in_array(false, $allowContinue)) {
            return response()->noContent(200);

        }
        $data_id = $curData['data']['id'];
        $data_parent = $curData['data']['parent_id'];

        $data_remove = $curData['remove'];
        $data_append = $curData['append'];

        $curCategory = Category::where('id', $data_id)->first();
        $curParent = Category::where('id', $data_parent)->first();

        if ($curCategory === null) {
            return response()->noContent(200);

        }

        ProductCategory::where('category_id', $curCategory->id)->whereIn('product_id', $data_remove)->delete();
        foreach ($data_append as $product_id) {
            ProductCategory::create(
                array(
                    'category_id' => $curCategory->id,
                    'product_id' => $product_id,
                )
            );
            if ($curParent !== null) {
                ProductCategory::create(
                    array(
                        'category_id' => $curParent->id,
                        'product_id' => $product_id,
                    )
                );
            }
        }

        // }
        return response()->noContent(200);
    }
    #endregion

}
