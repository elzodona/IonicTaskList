<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\RequestMessages;
use Illuminate\Database\QueryException;



class UserController extends Controller
{
    private $message;

    public function __construct()
    {
        $this->message = new RequestMessages();
    }

    public function compareId($id)
    {
        if (auth()->user()->id == $id) {
            return true;
        }
        return false;
    }

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

    public function destroy($idUser)
    {
        if ($this->compareId($idUser)) {
            try {
                $user = User::where('id', $idUser)->first();

                if ($user) {
                    $task = Task::where('user_id', $idUser)->get();
                    foreach ($task as $value) {
                        $value->delete();
                    }

                    $user->delete();
                    return $this->message->succedRequest($user, "user deleted succussfully!", 200);
                } else {
                    return $this->message->errorRequest("User not found or could not be deleted!", 404);
                }
            } catch (QueryException $e) {
                if ($e->getCode() == '23000');
                return $this->message->errorRequest("Processing Error !", 500);
            }
        } else {
            return $this->message->errorRequest('Unauthenticated', 500);
        }
    }

    public function loginUser(Request $request)
    {
        try {
                Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required|min:8'
                ]
            );

            if (!auth()->attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match'
                ]);
            }

            // $user = User::where('email', $request->email)->first();
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            $cookie = cookie("token", $token, 24 * 60);

            return response()->json([
                'status' => true,
                'message' => 'User logged in succesfully',
                'token' => $token,
                'user' => $user
            ])->withCookie($cookie);

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();

            $user->tokens()->delete();
            Cookie::forget("token");

            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully',
                'user' => $user
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }



}

