<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\updateProfileRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;

class MeController extends Controller
{

    public function updateProfileInfo(updateProfileRequest $request)
    {

        try {
            $postData = [
                'name' => $request->name,
                'username' => $request->username,
            ];
            $user_id = $request->id ?? auth()->id();
            $user = User::find($user_id);

            if (request()->hasFile('avatar') && $request->avatar != '') {
                $imagePath = Storage::disk('public')->path(str_replace(url('storage') . '/', '', $user->avatar));

                if ($user->avatar) {
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $postData['avatar'] = uploadImage('public', $request->avatar, 'profile');
            }
            if (request()->has('phone') && $request->phone != '') {
                $postData['phone'] = $request->phone;
            }
            if (request()->has('password') && $request->password != '') {
                $postData['password'] = bcrypt($request->password);
            }

            $user->update($postData);
            $user->load([
                'roles',
                'permissions',
            ]);
            return response()->json([
                'message' => 'User has been successfully updated',
                'user' => $user,
            ]);

        } catch (Exception $e) {
            return $e->getMessage();
            return response()->json(['message' => 'Unknown error'], 500);
        }
    }
}