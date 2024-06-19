<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductAccessTypeResource;
use App\Models\File;
use App\Models\ProductAccessType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{

    public static function useExampleService(ProductAccessType $product_access_type)
    {
        return response()->json(["message" => new ProductAccessTypeResource($product_access_type)], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            #region File Upload
            $curFile = $request->file('image');
            $fileName = $request->file('image')->getClientOriginalName();
            $ext = $request->file('image')->getClientOriginalExtension();
            $type = $request->file('image')->getClientMimeType();

            $file_name = $request->file('image')->getClientOriginalName();
            $generated_new_name = bin2hex($fileName) . '.' . $ext;
            $res['message'] = 'File upload success';

            $curFile = self::file_create(
                $fileName,
                $fileName . "." . $ext,
                $type,
            );
            $generated_new_name = bin2hex($curFile->id) . "." . $ext;
            #endregion
            $curFile = File::create(
                array(
                    'title' => $request->title,
                    'filename' => $request->filename,
                    'type' => $request->type,
                    'uploader_id' => $request->user_id,
                )
            );
            DB::commit();
            return $curFile;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        foreach ($request as $key => $value) {
            $file[$key] = $value;
        }
        $file->save();
        return $file;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        if (file_exists(public_path('storage/' . $file->filename))) {
            unlink(public_path('storage/' . $file->filename));
        }
        $file->delete();
        return true;
    }
}
