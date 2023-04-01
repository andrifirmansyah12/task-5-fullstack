<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response, 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // $user = Auth::user();\

            $user = $request->user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully!'
            ];

            return response()->json($response, 200);
        } else {
            $response = ["message" =>'User does not exist'];
            return response()->json($response, 422);
        }
    }

    public function register(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'Register successfully!'
        ];

        return response()->json($response, 200);
    }
}
