<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\AreaCode;
use App\Models\CompanyCode;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserArea;
use App\Models\UserCompany;
use App\Models\UserPermission;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{


    protected $UserServices;

    public function __construct(UserServices $UserServices)
    {
        $this->UserServices = $UserServices;
        
        
    }
    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::get());
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
    public function store(UserRequest $request)
    {
        $password = Str::random(10);
        $user = User::create(
            array(
                "name"      => $request->name,
                "email"     => $request->email,
                "password"  => Hash::make($password),

                "is_active" => true,
                "role_id"   => $request->has('role_id') ? $request->role_id : 2,
            )
        );
        $user['password'] = $password;
        return response()->json(['message' => 'User created successfully', 'user' => $user, 'password' => $password], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name ?? $user->name;
        $user->save();
        return response()->json(["message" => "User updated successfully"], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
    #endregion
    public static function updateRole(User $user, Role $role){
        $user->role_id = $role->id;
        $user->save();
        return response()->json(["message" => "User role has been changed to ".$role->title], 200);
    }
    public static function changePassword(UserRequest $request, User $user){
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(["message" => "Password has been changed"], 200);
    }
    public static function resetPassword(User $user){
        $password = Str::random(10);
        $user->password = Hash::make($password);
        $user->save();
        return response()->json(["message" => "Password has been reset", 'password' => $password], 200);
    }
    public static function modifyUserPermissions(User $user, $action, Permission $permission){
        if(!$user || !$permission ){
            return response()->json(["message" => "User or Permission not found"], 201);
        }
        switch ($action) {
            case 'append':
                $userPermission = UserPermission::where('user_id', $user->id)->where('permission_id', $permission->id);
                if( $userPermission->get()->count() > 0 ){
                    return response()->json(["message" => "".$user->name." has already have permission ".$permission->title.""], 201);
                }else{
                    UserPermission::create(
                        array(
                            "permission_id" => $permission->id,
                            "user_id" => $user->id
                        )
                    );
                    return response()->json(["message" => "Permission ".$permission->title." is added to ".$user->name], 200);
                }
                break;
            case 'remove':
                UserPermission::where('user_id', $user->id)->where('permission_id', $permission->id)->delete();
                return response()->json(["message" => $permission->title." is removed to ".$user->name." permissions."], 200);
                break;
            default:
                return response()->json(["message" => "Method not found"], 404);
                break;
        }
    }
    public static function modifyUserAreaCodes(User $user, $action, AreaCode $areacode){
        if(!$user || !$areacode ){
            return response()->json(["message" => "User or Area Code not found"], 201);
        }
        switch ($action) {
            case 'append':
                $UserArea = UserArea::where('user_id', $user->id)->where('area_code_id', $areacode->id);
                if( $UserArea->get()->count() > 0 ){
                    return response()->json(["message" => "".$user->name." is already in ".$areacode->title.""], 201);
                }else{
                    UserArea::create(
                        array(
                            "area_code_id" => $areacode->id,
                            "user_id" => $user->id
                        )
                    );
                    return response()->json(["message" =>$user->name." is added to ".$areacode->title], 200);
                }
                break;
            case 'remove':
                UserArea::where('user_id', $user->id)->where('area_code_id', $areacode->id)->delete();
                return response()->json(["message" => $user->name." is removed to ".$areacode->title], 200);
                break;
            default:
                return response()->json(["message" => "Method not found"], 404);
                break;
        }
    }
    public static function modifyUserCompanyCode(User $user, $action, CompanyCode $company_code){
        if(!$user || !$company_code ){
            return response()->json(["message" => "User or Area Code not found"], 201);
        }
        switch ($action) {
            case 'append':
                $UserCompanyCode = UserCompany::where('user_id', $user->id)->where('company_code_id', $company_code->id);
                if( $UserCompanyCode->get()->count() > 0 ){
                    return response()->json(["message" => "".$user->name." is already in ".$company_code->title.""], 201);
                }else{
                    UserCompany::create(
                        array(
                            "company_code_id" => $company_code->id,
                            "user_id" => $user->id
                        )
                    );
                    return response()->json(["message" =>$user->name." is added to ".$company_code->title], 200);
                }
                break;
            case 'remove':
                UserCompany::where('user_id', $user->id)->where('company_code_id', $company_code->id)->delete();
                return response()->json(["message" => $user->name." is removed to ".$company_code->title], 200);
                break;
            default:
                return response()->json(["message" => "Method not found"], 404);
                break;
        }
    }

}
