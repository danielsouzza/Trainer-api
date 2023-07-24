<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Sanctum\PersonalAccessToken;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function requestUser($request){
        $token = $request->bearerToken();
        $ownerToken = PersonalAccessToken::findToken($token);
        return User::findOrFail($ownerToken->tokenable_id)->userable;
    }
}
