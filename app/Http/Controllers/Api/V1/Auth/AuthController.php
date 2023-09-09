<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'string', 'max:255', 'confirmed', Password::defaults()]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'User' => $user
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request){
        $request->validate([
            'email' => ['required', 'string','email', 'max:255'],
            'password' => ['required', 'string', 'max:255']
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'Credential-error' =>  ['Incorrect credentials']
            ]);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);

        $expireAt = $request->remember ? null : now()->addMinutes(config('session.lifetime'));

        

        return response()->json([
            'access_token' => $user->createToken($device, expiresAt: $expireAt)->plainTextToken,
        ], Response::HTTP_CREATED);
    }
}
