<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6',
        ]);
        $input = $request->only('email', 'password');

        $token = null;

        if (!$token = auth('api')->attempt($input) && auth('api')->user()->hasRole('Reader')) {
            if(!User::where('email', $request->email)->first()){
                return response([
                    "errors"=>
                    ["email"=> "The email do not match our records."]
                ], 401);
            }else{
                return response([
                    "errors"=>
                    ["password"=> "The password do not match our records."]
                ], 401);
            }
        }
        $user = auth('api')->user();


        return fractal($user, new UserTransformer())
        ->addMeta($this->respondWithToken($token))
        ->respond(200);
    }

    /**
     * Register a User.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(RegisterRequest $request) {

        $validated = $request->validated();

        User::create(array_merge(
            $validated,
            ['password' => bcrypt($request->password)]
        ))->assignRole('Reader');

        $input = $request->only('email', 'password');

        $token = auth('api')->attempt($input);

        $user = auth('api')->user();

        return fractal($user, new UserTransformer())
        ->addMeta($this->respondWithToken($token))
        ->respond(201);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return Response
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Get the User data.
     *
     * @return Response
     */
    public function me()
    {
        $user = auth('api')->user();

        return fractal($user, new UserTransformer())
        ->respond(200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return object
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
