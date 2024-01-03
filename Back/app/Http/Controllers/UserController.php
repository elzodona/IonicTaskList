<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'user' => $user,
                'token' => $user->createToken("API_TOKEN")->plainTextToken,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'User creation failed',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $users = User::all();

        return response()->json([
            'user' => $users
        ]);
    }

    public function update(Request $request, $userId)
    {
        try {
            $user = User::findOrFail($userId);

            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $userId,
                'password' => 'sometimes|string|min:8',
            ]);

            $user->update([
                'name' => $validatedData['name'] ?? $user->name,
                'email' => $validatedData['email'] ?? $user->email,
                'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
                'user' => $user,
                'token' => $user->createToken("API_TOKEN")->plainTextToken,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'User update failed',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    
}
