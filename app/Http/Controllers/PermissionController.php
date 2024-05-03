<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    #region Default Function for Controllers

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PermissionResource::collection(Permission::get());
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
    public function store(PermissionRequest $request)
    {
        $permission = Permission::create(array(
            "key" => strtolower($request->key),
            "title" => ucwords($request->title),
            "description" => ucfirst($request->description) ?? "",
        ));
        return response()->json(['message' => 'Permission created successfully', 'permission' => $permission], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->key =ucwords($request->key) ?? $permission->key;
        $permission->title =ucwords($request->title) ?? $permission->title;
        $permission->description = ucfirst($request->description) ??  $permission->description;
        $permission->save();
        return response()->json(['message' => 'Permission updated successfully', 'Permission' => $permission], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully'], 200);
    }
    #endregion
}
