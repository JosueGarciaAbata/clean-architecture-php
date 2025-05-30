<?php
use Slim\Factory\AppFactory;

use Infrastructure\adapters\in\UserRestAdapter;

require __DIR__ . '/../../../../vendor/autoload.php';
$container = require __DIR__ . '/infrastructure/di/container.php';
$jwtMiddleware = $container->get(\Infrastructure\security\JwtAuthMiddleware::class);
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get("/api/auth/", UserRestAdapter::class . ":getAll")->addMiddleware($jwtMiddleware);
$app->post('/api/auth/login', UserRestAdapter::class . ':login');
$app->post('/api/auth/register', UserRestAdapter::class . ":register");

$app->run();