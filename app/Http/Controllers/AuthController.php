<?php

namespace App\Http\Controllers;

use App\Repository\Contracts\IUserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $user;

    public function __construct(IUserRepository $user)
    {
        $this->user = $user;
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $token = $this->user->login([
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response()->json($token, 200);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = $this->user->register($request->all());
        return $user ? response()->json([
            'message' => 'User created successful'
        ], 200) : response()->json([
            'message' => 'User failed creation'
        ], 500);
    }
}
