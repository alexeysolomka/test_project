<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userRepository;
    private $userService;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->userRepository = app(UserRepository::class);
        $this->userService = app(UserService::class);
    }

    public function index($limit = null, $offset = null)
    {
        if (isset($limit) && isset($offset)) {
            $users = DB::table('users')
                ->offset($offset)
                ->limit($limit)->get();
        } elseif (isset($limit)) {
            $users = DB::table('users')
                ->limit($limit)
                ->get();
        }
        elseif(isset($offset))
        {
            $users = DB::table('users')
                ->offset($offset)->get();
        }
        else
        {
            $users = DB::table('users')
                ->get();
        }

        return $users;
    }

    public function profile()
    {
        return auth()->user();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = $this->userRepository->create($data);

        return $user;
    }

    public function show($id)
    {
        $response = $this->userService->getUserForEdit($id);

        return $response;
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = $this->userRepository->update($id, $data);

        return $user;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete($id);
        return $user;
    }
}
