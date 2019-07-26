<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ValidateLoginRequest;
use App\Http\Requests\Api\v1\ValidateRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    /**
     * Register new user in database
     *
     * @param ValidateRegisterRequest $request
     * @return json response
     */
    public function register(ValidateRegisterRequest $request)
    {

        $user = new User;
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ], 200);
    }

    public function login(ValidateLoginRequest $request)
    {
        // Get some user from somewhere
        $user = User::first();

        // Get the token
        $token = auth()->login($user);

        if (!$token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(compact('token', 'user'));

    }

    public function user()
    {
        return response()->json(auth()->user());

    }
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'logout',
        ], 200);
    }
}
