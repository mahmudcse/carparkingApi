<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(Request $request){
        return ProfileResource::make($request->user());
    }

    public function updateProfile(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users')->ignore(auth()->user())]
        ]);

        $request->user()->update($validated);

        return ProfileResource::make($request->user());
    }

    public function updatePassword(Request $request){
        $validated = $request->validate([
            'current_password' => ['required', 'string', 'max:255', 'current_password'],
            'password' => ['required', 'confirmed', 'string', 'max:255', Password::defaults()]
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json([
            ProfileResource::make($request->user())
        ], Response::HTTP_ACCEPTED);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
