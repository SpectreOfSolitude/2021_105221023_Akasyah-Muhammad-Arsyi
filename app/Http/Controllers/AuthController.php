<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use TheSeer\Tokenizer\Exception;
use Illuminate\support\Facades\Validator;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        $validator = Validator::make
        (
            $request->only(['name', 'email', 'password']),
            [
                'name'      => ['required', 'string', 'min:5'],
                'email'     => ['required', 'email'],
                'password'  => ['required', 'string', 'min:8']
            ]
        );

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }
        try
        {
            User::create
            ([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password)
            ]);
        }
        catch (Exception $e)
        {
            return response()->json("Failed to register user because {$e->getMessage()}", 500);
        }
        
        return response()->json('User created', 201);
    }
}
