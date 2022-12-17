<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    public function login (Request $request) {

        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|max:200',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails())
            {
                return response(['errors'=>$validator->errors()->all()], 422);
            }
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('MyApp')->accessToken;
                    $response = ['token' => $token];
                    return response($response, 200);
                } else {
                    $response = ["errors" => ["Password mismatch"]];
                    return response($response, 422);
                }
            } else {
                $response = ["errors" =>['User does not exist']];
                return response($response, 422);
            }

        } catch (Throwable $e) {

            return response()->json(['error' => $e->getMessage()], 500);

        }

    }

    public function logout()
    {
        $token = auth()->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
