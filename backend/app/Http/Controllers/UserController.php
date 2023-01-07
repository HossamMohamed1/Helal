<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['roles', 'permissions'])->where('id', '!=', primaryID())
            ->where('id', '!=', auth()->id())->get();

        return response()->json([
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'same:password',
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'avatar' => 'image|mimes:png,jpg,jpeg',

        ]);
        $data['password'] = bcrypt($request->password);
        unset($data['confirm_password']);

        if (request()->hasFile('avatar') && $request->avatar != '') {
            $data['avatar'] = uploadImage('public', $request->avatar, 'profile');
        }

        User::create($data);

        return response()->json([
            'message' => 'User has been successfully created',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'password' => 'nullable|min:8',
            'confirm_password' => 'same:password',
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg',

        ]);

        $user = User::findOrFail($id);

        if (request()->hasFile('avatar') && $request->avatar != '') {
            if ($user->avatar) {
                $imagePath = Storage::disk('public')->path(str_replace(url('storage') . '/', '', $user->avatar));
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $data['avatar'] = uploadImage('public', $request->avatar, 'profile');
        }
        $user->update($data);

        return response()->json([
            'message' => 'User has been successfully updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar) {
            $imagePath = Storage::disk('public')->path(str_replace(url('storage') . '/', '', $user->avatar));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $user->delete();

        return response()->json([
            'message' => 'User has been successfully deleted',
        ]);
    }
}