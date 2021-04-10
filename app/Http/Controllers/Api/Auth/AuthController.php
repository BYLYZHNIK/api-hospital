<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
//    /**
//     * Create a new AuthController instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
//    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
//        dd($credentials);
        $user = User::where('email', $credentials['email'])->first();
//        $token = null;
//        dd($user);
        if (!$user)
            return response()->json(['error' => 'Unauthorized']);
//        dd($user);

//        dd(auth()->attempt($credentials));
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $this->respondWithToken($token),
        ]);
    }

    /**
     * User registration
     */
    public function registration(Request $request)
    {
//        dd($request->all());
//
     $input = [
            'name'      => request('name'),
            'last_name' => request('lastName'),
            'email'     => request('email'),
            'password'  => request('password'),
        ];
     $validator = Validator::make($input, User::regist_rules());
     if ($validator->fails())
        return response()->json($validator->errors());

     $input['password'] = Hash::make($input['password']);
     $user = User::create($input);
     return response()->json(['message' => 'Регистрация прошла успешно!']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ]);
    }
}
