<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class UserApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $users->createToken('token')->plainTextToken;

        $response = [
            'message' => 'User Registered Success!',
            'users' => $users,
            'token' => $token,
        ];
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $users = User::where('email', $request->email)->first();

        if (User::where('email', $request->email)->exists()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = $users->createToken('token')->plainTextToken;
                $response = [
                    'message' => 'User Login Success!',
                    'email' => $users->email,
                    'token' => $token,
                ];
                return response()->json($response);
            } else {
                return response(['message' => 'Wrong Password!']);
            }
        } else {
            return response(['message' => 'Email Does not Exists!']);
        }
    }

    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        $token->delete();
        return response(['message' => 'User Logout Success!']);
    }
}
