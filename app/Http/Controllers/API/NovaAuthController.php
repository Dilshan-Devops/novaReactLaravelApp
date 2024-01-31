<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NovaLoginRequest;
use App\Http\Requests\NovaRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NovaAuthController extends Controller
{
    public function novaRegister(NovaRegisterRequest $req) {
        //$data variable name referenced :  Register.jsx->novaAxiosClient.post('/regiser')({data})
        $data = $req->validated();

        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }

    public function novaLogin(NovaLoginRequest $req) {
        $credentials = $req->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided email or password is incorrect'
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }

    public function novaLogout(Request $req) {
        /** @var \App\Models\User $user */
        $user = $req->user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
