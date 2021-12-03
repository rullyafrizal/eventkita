<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiAuthenticationService
{

    public function register(Request $request)
    {
        DB::transaction(function () use ($request) {
            User::query()
                ->create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                ]);
        });
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            abort(401, 'Unauthenticated');
        }

        return [
            'access_token' => $this->generateToken($request->email)
        ];
    }

    protected function generateToken(string $email = '')
    {
        $user = User::query()
            ->where('email', $email)
            ->first();

        return $user->createToken('participant-token')->plainTextToken;
    }

    public function refresh(User $user)
    {
        $user->tokens()->delete();

        return $this->generateToken($user->email);
    }
}
