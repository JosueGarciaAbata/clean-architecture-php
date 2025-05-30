<?php

namespace Infrastructure\security;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;

class JwtAuthMiddleware implements MiddlewareInterface
{

    private JwtService $jwtService;

    public function __construct(JwtService $jwtService){
        $this->jwtService = $jwtService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!preg_match('/^Bearer\s+(.+)$/', $authHeader, $matches)) {
            return $this->unauthorized();
        }

        $token = $matches[1];
        $userId = $this->jwtService->validate($token);
        if ($userId === null) {
            return $this->unauthorized();
        }

        $request = $request->withAttribute('userId', $userId);
        return $handler->handle($request);
    }

    private function unauthorized(): ResponseInterface
    {
        $response = (new ResponseFactory())->createResponse(401);
        $response->getBody()->write(json_encode(['error' => 'Unauthorized']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}