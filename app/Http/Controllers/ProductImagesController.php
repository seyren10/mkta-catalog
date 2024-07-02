<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Http\Resources\ProductImageResource;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImagesController extends Controller
{
    public function index(Request $request){
        return FileResource::collection(File::where('type', 'LIKE', '%image%')->get());
    }
    

    /**
     * Display a listing of the resource.
     */
    public function show(Product $product)
    {
        return ProductImageResource::collection(ProductImage::where('product_id', $product->id)->orderBy('index', 'ASC')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ProductImage::create(
            array(
                "product_id" => $request->product_id,
                "is_thumbnail" => $request->is_thumbnail,
                "file_id" => $request->file_id,
            )
        );
        return response()->json(['message' => 'Product Image successfully added'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductImage $product_image)
    {
        // ProductImage::where('product_id', $product_image->product_id)->update([0, 'is_thumbnail']);
        ProductImage::where('product_id', $product_image->product_id)->update(['is_thumbnail' => 0]);
        $product_image->is_thumbnail = 1;
        $product_image->save();
        return response()->json(['message' => 'Product Thumbnail successfully updated'], 200);
    }
    public function move(Request $request, ProductImage $product_image)
    {
        $affected_ProductImage = ProductImage::where('product_id', $product_image->product_id)->where('index', $product_image->index);
        if($affected_ProductImage->get()->count() == 1){
            $affected_ProductImage = $affected_ProductImage->get()->first();
            $affected_ProductImage->index = $affected_ProductImage->index + ($request->step);
            $affected_ProductImage->save();
        }

        $product_image->index = $product_image->index + $request->step;
        $product_image->save();
        return response()->json(['message' => 'Product Thumbnail successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        $productImage->delete();
    }
}
