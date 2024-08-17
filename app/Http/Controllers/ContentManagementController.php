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

        if ($query->isEmpty()) {
            ContentManagement::create([
                'title' => 'default',
                'data' => "[]",
                'active' => true
            ]);

            $query = ContentManagement::all();
        }

        return ContentManagementResource::collection($query);
    }

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentManagement $content_management)
    {
        $content_management->update([
            ...$request->all()
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentManagement $contentManagement)
    {
        //
    }

    public function setActiveContent(ContentManagement $content_management)
    {
        $currentlyActiveContent = ContentManagement::where('active', true);
        $currentlyActiveContent->update([
            'active' => false
        ]);

        $content_management->update([
            'active' => true
        ]);

        return new ContentManagementResource($content_management);
    }
}
