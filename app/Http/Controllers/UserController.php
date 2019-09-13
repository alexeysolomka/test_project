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
        $this->userRepository = app(UserRepository::class);
        $this->userService = app(UserService::class);
    }

    public function create()
    {
        $roles = $this->userService->getUserRoles();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return route
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->all();
        $data['avatar'] = null;

        if ($request->has('avatar')) {
            $imagePath = $this->userService->uploadAvatar($request->email, $request->file('avatar'));
            $data['avatar'] = $imagePath;
        }

        $user = $this->userRepository->create($data);
        if (!empty($user)) {
            $user->touch();
            return back()->with('status', 'User successful created.');
        }

        return back()->with('error', 'Error to create user.')
            ->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return view
     */
    public function edit($id)
    {
        $user = $this->userService->getUserForEdit($id);
        $roles = $this->userService->getUserRoles();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return route
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return route
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->delete($id)) {
            return back()->with('status', 'User successful deleted.');
        }

        return back()->with('error', 'Error to delete user.');
    }
}
