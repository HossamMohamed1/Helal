<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')
            ->get();
        return RoleResource::collection($roles);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $role['permissions'] = $role->permissions()->get()->pluck('name');
        $permissions = Permission::get()->groupBy('group');

        return response()->json([
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name',
        ]);
        $data = $request->only([
            'name',
            'display_name',
        ]);
        $role = Role::find($id);
        $role->update($data);

        $role->syncPermissions($request->permissions);

        return response()->json([
            'message' => 'Role has been updated successfully',
        ]);

    }

    public function permissions()
    {
        $permissions = Permission::get()->groupBy('group');

        return response()->json([
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name',
        ]);

        $data = $request->only([
            'name',
            'display_name',
        ]);
        $data['guard_name'] = 'web';
        $role = Role::create($data);
        $role->syncPermissions($request->permissions);

        return response()->json([
            'message' => 'Role has been created successfully',
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'message' => 'Role has been deleted successfully',
        ]);
    }
}