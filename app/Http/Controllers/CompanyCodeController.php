<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCodeRequest;
use App\Http\Resources\CompanyCodeResource;
use App\Models\CompanyCode;
use Illuminate\Http\Request;

class CompanyCodeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CompanyCodeResource(CompanyCode::get());
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
    public function store(CompanyCodeRequest $request)
    {
        $CompanyCode = CompanyCode::create(array(
            "title" => ucwords($request->title),
            "description" => ucfirst($request->description) ?? "",
        ));
        return response()->json(['message' => 'Company Code created successfully', 'company_code' => $CompanyCode], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyCode $company_code)
    {
        return new CompanyCodeResource($company_code);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyCode $CompanyCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyCodeRequest $request, CompanyCode $company_code)
    {
        $company_code->title =ucwords($request->title) ?? $company_code->title;
        $company_code->description = ucfirst($request->description) ?? $company_code->description;
        $company_code->save();
        return response()->json(['message' => 'Company Code updated successfully', 'area_code' => $company_code], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyCode $company_code)
    {
        $company_code->delete();
        return response()->json(['message' => 'Company Code deleted successfully'], 200);
    }
}
