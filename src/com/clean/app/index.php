<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept, Origin, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

use Slim\Factory\AppFactory;
use Infrastructure\adapters\in\UserRestAdapter;

require __DIR__ . '/../../../../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
$dotenv->load();

$container = require __DIR__ . '/infrastructure/di/container.php';
$jwtMiddleware = $container->get(\Infrastructure\security\JwtAuthMiddleware::class);
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get("/api/auth/", UserRestAdapter::class . ":getAll")->addMiddleware($jwtMiddleware);
$app->post('/api/auth/login', UserRestAdapter::class . ':login');
$app->post('/api/auth/register', UserRestAdapter::class . ":register");

$app->run();