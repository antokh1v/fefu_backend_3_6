<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginFormRequest;
use App\Http\Requests\ApiRegisterFormRequest;
use App\Http\Requests\BaseLoginFormRequest;
use App\Http\Requests\BaseRegisterFormRequest;
use App\Models\User;
use App\OpenApi\Parameters\Auth\LoginParameters;
use App\OpenApi\Parameters\Auth\RegisterParameters;
use App\OpenApi\Responses\Auth\LogoutSuccessResponse;
use App\OpenApi\Responses\Auth\TokenSuccessResponse;
use App\OpenApi\Responses\Auth\UnauthenticatedResponse;
use App\OpenApi\Responses\Auth\ValidationFailedResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class AuthApiController extends Controller
{
    /**
     * @param ApiLoginFormRequest $request
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ["auth"], method: "POST")]
    #[OpenApi\Response(factory: TokenSuccessResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ValidationFailedResponse::class, statusCode: 422)]
    #[OpenApi\Parameters(factory: LoginParameters::class)]
    public function login(ApiLoginFormRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data, true)) {
            $user = Auth::user();
            $token = $user->createToken(request()->userAgent())->plainTextToken;
            return response()->json(['token' => $token]);
        }
        return response()->json(['errors' => ['' => 'The provided credentials are incorrect.']], 422);
    }

    /**
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ["auth"], method: "POST")]
    #[OpenApi\Response(factory: LogoutSuccessResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: UnauthenticatedResponse::class, statusCode: 401)]
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json([], 200);
    }

    /**
     * @param ApiRegisterFormRequest $request
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ["auth"], method: "POST")]
    #[OpenApi\Response(factory: TokenSuccessResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ValidationFailedResponse::class, statusCode: 422)]
    #[OpenApi\Parameters(factory: RegisterParameters::class)]
    public function register(ApiRegisterFormRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::createFromRequest($data);
        $token = $user->createToken(request()->userAgent())->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
