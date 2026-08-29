<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public const ALLOWED_ABILITIES = [
        'services:read',
        'registrations:create',
        'registrations:read',
    ];

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required_without:username', 'nullable', 'email'],
            'username' => ['required_without:email', 'nullable', 'string'],
            'password' => ['required', 'string'],
            'client_name' => ['required_without:device_name', 'nullable', 'string', 'max:255'],
            'device_name' => ['required_without:client_name', 'nullable', 'string', 'max:255'],
            'abilities' => ['sometimes', 'array', 'min:1'],
            'abilities.*' => ['string', Rule::in(self::ALLOWED_ABILITIES)],
        ]);

        $credentialField = $request->filled('email') ? 'email' : 'username';
        $user = User::where($credentialField, $validated[$credentialField])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                $credentialField => [__('auth.failed')],
            ]);
        }

        $abilities = $validated['abilities'] ?? self::ALLOWED_ABILITIES;
        $tokenName = $validated['client_name'] ?? $validated['device_name'];
        $token = $user->createToken($tokenName, $abilities)->plainTextToken;

        return response()->json([
            'token_type' => 'Bearer',
            'token' => $token,
            'abilities' => $abilities,
            'client' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'token_name' => $tokenName,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
