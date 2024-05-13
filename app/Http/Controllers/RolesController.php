<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Error;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class RolesController extends Controller
{

    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoleResource::collection(Role::get());
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
    public function store(RoleRequest $request)
    {
        $role = Role::create(array(
            "title" => ucwords($request->title),
            "description" => ucfirst($request->description) ?? "",
        ));
        return response()->json(['message' => 'Role created successfully', 'role' => $role], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->title =ucwords($request->title) ?? $role->title;
        $role->description = ucfirst($request->description) ?? $role->description;
        $role->save();
        return response()->json(['message' => 'Role updated successfully', 'role' => $role], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully'], 200);

    }
    #endregion
    public static function modifyRolesPermission(Role $role, $action, Permission $permission){
        if(!$role || !$permission ){
            return response()->json(["message" => "Role or Permission not found"], 201);
        }
        switch ($action) {
            case 'append':
                $RolePermission = RolePermission::where('role_id', $role->id)->where('permission_id', $permission->id);
                if( $RolePermission->get()->count() > 0 ){
                    return response()->json(["message" => "Role ".$role->title." with permission ".$permission->title." is already included"], 201);
                }
                RolePermission::create(
                    array(
                        "permission_id" => $permission->id,
                        "role_id" => $role->id
                    )
                );
                return response()->json(["message" => "Permission ".$permission->title." is added in the Role ".$role->title], 200);
                break;
            case 'remove':
                $RolePermission = RolePermission::where('role_id', $role->id)->where('permission_id', $permission->id)->delete();
                return response()->json(["message" => "Permission ".$permission->title." is removed in the Role ".$role->title], 200);
                break;
            default:
                return response()->json(["message" => "Method not found"], 404);
                break;
        }
    }
}
