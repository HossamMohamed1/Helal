<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\IUser;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UsersRepository extends BaseRepository implements IUser
{
    public function model()
    {
        return User::class;
    }

    public function createWithRoles(array $data, array $roles)
    {
        try {
            DB::beginTransaction();
            // add new db record
            $data['email_verified_at'] = now();
            $user = parent::create($data);
            // sync user roles
            $user->syncRoles((new RolesRepository())->getByNameIn($roles));
            // send verification code with mail
            try {
                //code...
                // $user->sendEmailVerificationNotification();
            } catch (Throwable $th) {
                //
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateWithRoles($id, array $data, array $roles)
    {
        try {
            DB::beginTransaction();

            $user = parent::update($id, $data);
            $user->syncRoles((new RolesRepository())->getByNameIn($roles));

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProfile($id, $password, array $data)
    {
        try {
            $current_password = auth()->user()->password;
            if (Hash::check($password, $current_password)) {
                DB::beginTransaction();
                $user = parent::update($id, $data);
                DB::commit();
                return $user;
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            throw $e;
        }
    } // end updateProfile
}