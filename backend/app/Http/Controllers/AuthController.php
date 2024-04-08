<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    
    public function register(AuthRequest $request)
    {

        try {
            $validatedData = $request->validated();

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password'])
            ]);
    
            $token = $user->createToken('myToken')->plainTextToken;
    
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response()->json([200, $response]);

        } catch (\Throwable $th) {
            echo $th->getMessage(),'YOUR RESQUEST ERROR';
            return response()->json(['error'=> $th->getMessage()],500);
        }
    }

    public function login(LoginAuthRequest $request)
    {

        try {
            $fields = $request->validated();

            // Find the user by email
            $user = User::where('email', $fields['email'])->first();
    
    
            if (!$user || !Hash::check($fields['password'], $user->password)) {
                return response()->json([
                    'error' => 'Incorrect email or password'
                ], 400);
            }
    
            $token = $user->createToken('myToken')->plainTextToken;
    
            $response = [
                'user' => $user,
                'token' => $token
            ];
    
            return response()->json([200, $response]);
        } catch (\Throwable $th) {
            echo $th->getMessage(),'YOUR RESQUEST ERROR';
            return response()->json(['error'=> $th->getMessage()],500);
        }

    }

    public function logout(){
        try {
            Auth::logout();
            return response()->json([
                'message' => 'Logged out'
    
            ]);
        } catch (\Throwable $th) {
            echo $th->getMessage(),'YOUR RESQUEST ERROR';
            return response()->json(['error'=> $th->getMessage()],500);
        }

    }
}
