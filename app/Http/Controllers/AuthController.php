<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Users\App\Resources\UserResource;

class AuthController extends Controller
{
    public function login(LoginRequest $request) :JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] =new UserResource($user);
        auth()->login($user);
        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];
        return response()->json($response);
    }
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'role' => 'customer'
        ]);
        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = new UserResource($user);
        $response = [
            'status' => 'success',
            'message' => 'User is registered successfully.',
            'data' => $data,
        ];
        return response()->json($response);
    }
    public function logout() :JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
        ], 200);
    }

    public function user() : JsonResponse
    {
        $user = auth()->user();
        return response()->json(
            new UserResource($user)
        );
    }
}
