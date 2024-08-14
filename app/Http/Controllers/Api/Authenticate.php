<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\RequestMessages;

class Authenticate extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            $user =  User::create([
                 'name' => $validatedData['name'],
                 'email' => $validatedData['email'],
                 'password' => bcrypt($validatedData['password']),
                 'role' => $validatedData['role']
             ]);
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
               'token' => $token,
               'user' => $user
        ], 200);

        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }



    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }


        $user = auth()->user();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user], 200);


    }
}
