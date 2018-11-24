<?php

namespace App\Http\Controllers\Auth;

use Tymon\JWTAuth\JWTAuth;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Transformers\UserTransformer;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\UserRegistrationRequest;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    private $userService;
    private $authService;

    public function __construct(UserService $userService, JWTAuth $auth)
    {
        $this->userService = $userService;
        $this->authService = $auth;
    }

    public function login(UserLoginRequest $request)
    {
        $token = $this->authService->attempt(
            $request->only(['email', 'password'])
        );

        if (!$token) {
            return $this->sendResponse(
                null,
                'Wrong credentials',
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $this->success([
            'token' => $token,
        ]);
    }

    public function refreshToken()
    {
        try {
            $token = $this->authService->parseToken()->refresh();
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }

        return $this->response->array([
                'token' => $token
        ]);
    }

    public function getUser(Request $request)
    {
        return $this->response->item($request->user(), new UserTransformer());
    }

    public function register(UserRegistrationRequest $request)
    {
        return $this->userService->create($request->all());
    }

    public function invalidate()
    {
        $token = $this->authService->parseToken();
        $token->invalidate();

        return $this->success();
    }
}
