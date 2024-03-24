<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class UserController extends Controller

{
    //login
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
      

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return response()->json(['message' => 'Login successful'], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
        
    }

    //registration

    public function register(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|email|unique:account,email',
        'username' => 'required|string|unique:account,username',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    

    // Create a new user
    $user = new Account();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->username = $request->input('username');
    $user->password = bcrypt($request->input('password'));
    $user->save();

    return response()->json(['message' => 'User registered successfully'], 201);
}


}
