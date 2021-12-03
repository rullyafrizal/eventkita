<?php

namespace App\Http\Controllers\Api;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        auth()->user()->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password ?
                bcrypt($request->password) :
                auth()->user()->password,
        ]);

        return api_response(
            HttpStatus::OK,
            'Success update user account'
        );
    }
}
