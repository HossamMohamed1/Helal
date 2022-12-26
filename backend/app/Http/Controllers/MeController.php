<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\updateProfileRequest;
use App\Models\User;
use App\Repositories\Eloquent\UsersRepository;
use Exception;

class MeController extends Controller
{
    private $repo;
    public function __construct(UsersRepository $repo)
    {
        dd('asd');
        $this->repo = $repo;
    }

    // User/updateProfileRequest
    public function updateProfileInfo(updateProfileRequest $request)
    {
        return 'asd';
        try {
            $postData = [
                'name' => $request->name,
                'username' => $request->username,
            ];
            if (request()->hasFile('image') && $request->image != '') {
                $user = User::find($request->id);
                if ($user->image) {
                    $imagePath = storage_path('profile/' . $user->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $postData['image'] = uploadImage('tmp', $request->image, 'profile');
            }
            if (request()->has('phone') && $request->phone != '') {
                $postData['phone'] = $request->phone;
            }
            if (request()->has('newpassword') && $request->newpassword != '') {
                $postData['password'] = bcrypt($request->newpassword);
            }
            return $this->repo->updateProfile($request->id, $request->password, $postData);
        } catch (Exception $e) {
            return response()->json(['message' => 'Unknown error'], 500);
        }
    }
}