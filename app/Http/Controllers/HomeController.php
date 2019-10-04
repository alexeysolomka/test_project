<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->userRepository = app(UserRepository::class);
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return view('home', compact('users'));
    }
}
