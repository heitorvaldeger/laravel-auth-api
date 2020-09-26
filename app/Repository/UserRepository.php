<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Contracts\IUserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserRepository implements IUserRepository{
    public function login(array $data){
        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            throw ValidationException::withMessages([
                'message' => 'Credentials incorrets'
            ]);
        }

        return $user->createToken('auth-token');
    }

    public function register(array $data){
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        return $user;
    }
}