<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Http\Resources\ProductAccessTypeResource;
use App\Models\File;
use App\Models\ProductAccessType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response as Download;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public static function useExampleService(ProductAccessType $product_access_type)
    {
        return response()->json(["message" => new ProductAccessTypeResource($product_access_type)], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function indexCache()
    {
        /* add reset params to get the latest File data */
        // if (request()->has('reset')) {
        //     Cache::store('file')->forget('portal-files');
        // }

        // $files = Cache::store('file')->remember('portal-files', now()->addHour(), function () {
        //     return File::orderBy('created_at', "DESC")->get();
        // });

        // return FileResource::collection($files);

        return FileResource::collection(File::orderBy('created_at', "DESC")->get());
    }

    public function index()
    {
        return FileResource::collection(File::orderBy('created_at', 'DESC')->get());
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
            $curFile = $request->file('eFile');
            $fileName = $curFile->getClientOriginalName();
            $ext = $curFile->getClientOriginalExtension();
            $type = $curFile->getClientMimeType();

            $generated_new_name = bin2hex(now() . $fileName) . "." . $ext;
            $data = Storage::disk('s3')->put("", $request->file('eFile'));

            #endregion
            $curFile = File::create(
                array(
                    'title' => $fileName,
                    'filename' => $data,
                    'type' => $type,
                )
            );
            DB::commit();

            return response(array(
                "s3" => $data,
                "data" => $curFile,
                "message" => "File uploaded successfully.",
            ), 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $th;
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     */

    public function download($filename)
    {
        if (Storage::disk('s3')->exists($filename)) {
            $headers = [
                'Content-Type' => 'Content-Type: application/zip',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            return Download::make(Storage::disk('s3')->get($filename), Response::HTTP_OK, $headers);
        } else {
            return Storage::disk('s3')->get("defaultImage.png");
        }
    }
    public function show($filename)
    {
        if (Storage::disk('s3')->exists($filename)) {
            // Get the file's URL from S3

            return Storage::disk('s3')->get($filename);

            // Redirect the user to the S3 URL for downloading

        } else {
            return Storage::disk('s3')->get("defaultImage.png");
        }
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
    public function update(Request $request, File $portal_file)
    {
        $portal_file->title = $request->title ?? $portal_file->title;
        $portal_file->save();
        return response(array(
            "message" => "File successfully updated",
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $portal_file)
    {
        $res = array();
        $res["message"] = "File successfully deleted";
        $res["File"] = $portal_file->filename;
        $res["isExist"] = Storage::disk('s3')->exists($portal_file->filename);

        if (Storage::disk('s3')->exists($portal_file->filename)) {
            try {
                Storage::disk('s3')->delete("\\" . $portal_file->filename);
            } catch (\Throwable $th) {
                $res["error"] = $th;
                $res['file'] = "\\" . $portal_file->filename;
            }
        }
        $portal_file->delete();
        return response(array(
            $res,
        ), 200);
    }
}
