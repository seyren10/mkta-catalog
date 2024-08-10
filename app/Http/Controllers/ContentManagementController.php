<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContentManagementResource;
use App\Models\ContentManagement;
use Illuminate\Http\Request;

class ContentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = ContentManagement::all();
        return ContentManagementResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ContentManagement::updateOrCreate(
            ['title' => $request->title],
            [...$request->all()]
        );

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentManagement $content_management)
    {
        return new ContentManagementResource($content_management);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentManagement $contentManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentManagement $contentManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentManagement $contentManagement)
    {
        //
    }
}
