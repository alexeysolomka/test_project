<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function index(Request $request)
    {
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        if (isset($limit) && isset($offset)) {
            $users = DB::table('users')
                ->offset($offset)
                ->limit($limit)->get();
        } elseif (isset($limit)) {
            $users = DB::table('users')
                ->limit($limit)
                ->get();
        } elseif (isset($offset)) {
            return response()->json('Bad request. If is set offset then must have limit.', 400);
        } else {
            $users = DB::table('users')
                ->get();
        }

        return $users;
    }

    public function profile()
    {
        return new UserResource(auth()->user());
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validation = Validator::make($request->all(), [$user->updateUserRules($user->id)]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            return response()->json(['errors' => $errors]);
        }
        $data = $request->all();
        $user = $this->userRepository->update(auth()->user()->id, $data);

        return $user;
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validation = Validator::make($request->all(), $user->createUserRules());
        if($validation->fails())
        {
            $errors = $validation->errors();
            return response()->json(['errors' => $errors]);
        }
        $data = $request->all();
        $user = $this->userRepository->create($data);

        return new UserResource($user);
    }

    public function show($id)
    {
        $response = $this->userService->getUserForEdit($id);

        if ($response instanceof User) {
            return new UserResource($response);
        }

        return $response;
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $validation = Validator::make($request->all(), $user->updateUserRules($id));
        if($validation->fails())
        {
            $errors = $validation->errors();
            return response()->json(['errors' => $errors]);
        }

        $data = $request->all();
        $user = User::find($id);
        $user->update($data);

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->delete($id)) {
            return new UserResource($user);
        }
        return response()->json('Bad request.', 400);
    }
}
