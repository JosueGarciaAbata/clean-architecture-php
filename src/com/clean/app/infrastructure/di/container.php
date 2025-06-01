<?php

use Application\in\RegisterUser;
use Application\out\UserRepository;
use Application\usecases\LoginUserInteractor;
use Application\usecases\RegisterUserInteractor;
use Infrastructure\adapters\out\DoctrineUserRepository;
use Infrastructure\adapters\in\UserRestAdapter;
use Application\usecases\GetUsersInteractor;
use Application\in\LoginUser;
use Application\in\GetUsers;
use Infrastructure\security\JwtAuthMiddleware;

use DI\ContainerBuilder;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Infrastructure\security\JwtService;
use function DI\autowire;
use function DI\factory;
use Dotenv\Dotenv;

$paths = [__DIR__ . '/../adapters/out'];
$isDev = true;

$dbParams = [
    'driver'   => $_ENV['DB_DRIVER'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'dbname'   => $_ENV['DB_NAME'],
    'host'     => $_ENV['DB_HOST'],
    'port'     => $_ENV['DB_PORT'],
];

return (new ContainerBuilder())
    ->addDefinitions([
        // EntityManager
        EntityManagerInterface::class => factory(function() use ($paths, $isDev, $dbParams) {
            // 1) Configuración
            $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDev);
            // 2) Conexión
            $connection = DriverManager::getConnection($dbParams, $config);
            // 3) EntityManager
            return new EntityManager($connection, $config);
        }),
        // Repositorios
        DoctrineUserRepository::class => autowire(),
        UserRepository::class => autowire(DoctrineUserRepository::class),
        // Casos de uso
        RegisterUser::class => autowire(RegisterUserInteractor::class),
        LoginUser::class => autowire(LoginUserInteractor::class),
        GetUsers::class => autowire(GetUsersInteractor::class),
        // Servicios generales
        JwtService::class => autowire(),
        JwtAuthMiddleware::class => autowire(), // El middleware: autowire deduce que necesita un JwtService
        // Adaptadores
        UserRestAdapter::class => autowire()
    ])
    ->build();