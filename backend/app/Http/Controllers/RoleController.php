<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('name', 'like', primaryID() . ".%")->with('permissions')
            ->get();
        return RoleResource::collection($roles);
    }
}