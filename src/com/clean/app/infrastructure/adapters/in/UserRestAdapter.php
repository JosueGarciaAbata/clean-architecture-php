<?php

namespace Infrastructure\adapters\in;

use Application\in\GetUsers;
use Application\in\LoginUser;
use Application\in\RegisterUser;
use Domain\model\User;
use Infrastructure\adapters\in\response\UserResponse;
use Infrastructure\security\JwtService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class UserRestAdapter
{
    private RegisterUser $registerUser;
    private LoginUser $loginUser;
    private GetUsers $getUsers;

    private JwtService $jwtService;

    public function __construct(RegisterUser $registerUser,  LoginUser $loginUser, GetUsers $getUsers, JwtService $jwtService)
    {
        $this->registerUser = $registerUser;
        $this->loginUser = $loginUser;
        $this->getUsers = $getUsers;
        $this->jwtService = $jwtService;
    }

    public function getAll(Request $request, Response $response): Response {
        $users = $this->getUsers->getAll();

        $dtos = array_map(
            fn(User $u): UserResponse => new UserResponse($u->getId(), $u->getName(), $u->getEmail()),
            $users
        );

        $payload = array_map(
            fn(UserResponse $dto) => $dto->toArray(),
            $dtos
        );

        $final = [
            "users" => $payload,
        ];

        $response->getBody()->write(json_encode($final));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function login(Request $request, Response $response): Response
    {
        $data = json_decode((string)$request->getBody(), true);
        $userRequest = new User("", $data['email'], $data['password']);
        $loggedInUser = $this->loginUser->login($userRequest);

        $token = $this->jwtService->generate($loggedInUser);

        $payload = [
            "user" => ["id" => $loggedInUser->getId(),
                        "name" => $loggedInUser->getName(),
                       "email" => $loggedInUser->getEmail()],
            'token' => $token,
        ];

        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function register(Request $request, Response $response): Response {
        $data = json_decode((string)$request->getBody(), true);
        $user = new User($data["name"],  $data["email"], $data["password"]);

        // execute this use case...
        $saved = $this->registerUser->register($user);

        // then generate the token...
        $token = $this->jwtService->generate($saved);

        $payload = [
            "user" => [
                'id' => $saved->getId(),
                'name' => $saved->getName(),
                'email' => $saved->getEmail(),
            ],
            "token" => $token
        ];

        $response->getBody()->write(json_encode($payload));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

}