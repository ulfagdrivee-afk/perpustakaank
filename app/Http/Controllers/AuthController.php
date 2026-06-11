<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:6',
            'level' => 'required|in:admin,petugas', 
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error', 
                'message' => 'Invalid Field', 
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password), 
            'level' => $request->level, 
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'Registration Successfull',
            'data' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'level' => $user->level,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'token' => $token
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100', 
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error', 
                'message' => 'Invalid Field', 
                'errors' => $validator->errors()
            ], 422);
        }

        if(!Auth::attempt($request->only('username', 'password'))){
            return response()->json([
                'status' => 'Error',
                'message' => 'Username atau Password salah'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'Login Berhasil',
            'data' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'level' => $user->level,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'token' => $token
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'Success', 
            'message' => 'Logout Berhasil'
        ], 200);
    }
}