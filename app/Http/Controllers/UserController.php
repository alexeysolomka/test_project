<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\User;

class UserController extends Controller
{
    private $userRepository;
    private $userService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->userRepository = app(UserRepository::class);
        $this->userService = app(UserService::class);
    }

    public function create()
    {
        $roles = $this->userService->getUserRoles();

        return view('users.create', compact('roles'));
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->all();

        if ($request->has('avatar')) {
            $imagePath = $this->userService->uploadAvatar($request->email, $request->file('avatar'));
            $data['avatar'] = $imagePath;
        }

        $user = $this->userRepository->create($data);
        if (!empty($user)) {
            return back()->with('status', 'User successful created.');
        }

        return back()->with('error', 'Error to create user.')
            ->withInput();
    }

    public function edit($id)
    {
        $response = $this->userService->getUserForEdit($id);
        $roles = $this->userService->getUserRoles();

        if($response instanceof User)
        {
            return view('users.edit', ['user' => $response, 'roles' => $roles]);
        }

        return $response;
    }

    public function profile($userId)
    {
        $user = User::find($userId);

        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->all();
        if ($request->has('avatar')) {
            $this->userService->deleteImageIfExist($id);
            $imagePath = $this->userService->uploadAvatar($request->email, $request->file('avatar'));
            $data['avatar'] = $imagePath;
        }
        $user = $this->userRepository->update($id, $data);

        return back()->with('status', 'User successful updated.');
    }

    public function removeAvatar($userId)
    {
        if($this->userService->deleteImageIfExist($userId))
        {
            return back()->with('status', 'Avatar successful deleted.');
        }

        return back()->with('error', 'Error to delete avatar.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->delete($id)) {
            return back()->with('status', 'User successful deleted.');
        }

        return back()->with('error', 'Error to delete user.');
    }
}
