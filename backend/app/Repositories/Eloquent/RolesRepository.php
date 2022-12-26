<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\IRole;
use Exception;
use Illuminate\Support\Facades\DB;

class RolesRepository extends BaseRepository implements IRole
{
    public function model()
    {
        return Role::class;
    }

    public function all()
    {
        return $this->getModelClass()->where('name', 'like', primaryID() . ".%")->with('permissions')->get();
    }

    public function getByNameIn(array $roles)
    {
        return $this->getModelClass()->where('name', 'like', primaryID() . ".%")
            ->whereIn('name', $roles)
            ->get();
    }

    public function createWithPermissions(array $data, array $permissions)
    {
        try {
            DB::beginTransaction();
            $role = parent::create($data);
            $role->syncPermissions($permissions);
            DB::commit();

            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateWithPermissions($id, array $data, array $permissions)
    {
        try {
            DB::beginTransaction();
            $role = parent::update($id, $data);
            $role->syncPermissions($permissions);
            DB::commit();

            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}