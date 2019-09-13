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
     * @param  \Illuminate\Http\Request  $request
     * @return route
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->userRepository->create($request);
        if(!empty($user))
        {
            $user->touch();
            return back()->with('status', 'User successful created.');
        }

        return back()->with('error', 'Error to create user.')
            ->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return route
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userRepository->update($id, $request);

        return back()->with('status', 'User successful updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return route
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->delete($id))
        {
            return back()->with('status', 'User successful deleted.');
        }

        return back()->with('error', 'Error to delete user.');
    }
}
