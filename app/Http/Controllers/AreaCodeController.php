<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaCodeRequest;
use App\Http\Resources\AreaCodeResource;
use App\Models\AreaCode;
use Illuminate\Http\Request;

class AreaCodeController extends Controller
{
    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AreaCodeResource(AreaCode::get());
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
    public function store(AreaCodeRequest $request)
    {
        $AreaCode = AreaCode::create(array(
            "title" => ucwords($request->title),
            "description" => ucfirst($request->description) ?? "",
        ));
        return response()->json(['message' => 'Area Code created successfully', 'area_code' => $AreaCode], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaCode $area_code)
    {
        return new AreaCodeResource($area_code);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaCode $AreaCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaCodeRequest $request, AreaCode $area_code)
    {
        $area_code->title =ucwords($request->title) ?? $area_code->title;
        $area_code->description = ucfirst($request->description) ?? $area_code->description;
        $area_code->save();
        return response()->json(['message' => 'Area Code updated successfully', 'area_code' => $area_code], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaCode $area_code)
    {
        $area_code->delete();
        return response()->json(['message' => 'Area Code deleted successfully'], 200);

    }
    #endregion
}
