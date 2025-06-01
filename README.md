# clean-architecture-php

Practice with clean architecture (hexagonal) to gain a stronger foundation in concepts such as IoC, ports, interfaces, adapters, etc.

This PHP project uses Composer to manage its packages. Run: composer install

**Database:** PostgreSQL
**Configuration:** Environment variables are loaded from `.env` using `vlucas/phpdotenv`.

| Packages               | Version | Description                                                                                                       |
| ---------------------- | ------- | ----------------------------------------------------------------------------------------------------------------- |
| `php-di/php-di`        | ^7.0    | Inversion of Control (IoC) container and DI, automatically resolves classes and dependencies.                     |
| `doctrine/orm`         | ^3.3    | Object-Relational Mapper (ORM) for mapping objects to database tables and working with entities and repositories. |
| `rekalogika/mapper`    | ^2.0    | Utility for mapping properties between objects (ideal for DTOs and entities).                                     |
| `firebase/php-jwt`     | ^6.11   | Generation and validation of JSON Web Tokens (JWT) for token-based authentication.                                |
| `psr/http-message`     | \*      | PSR-7 standard interfaces for representing HTTP requests and responses.                                           |
| `slim/slim`            | 4.\*    | Lightweight micro-framework for building web APIs and applications.                                               |
| `slim/psr7`            | \*      | PSR-7 implementation used internally by Slim for HTTP message handling.                                           |
| `php-di/slim-bridge`   | \*      | Bridge integrating PHP-DI with Slim, enabling dependency injection in controllers and middleware.                 |
| `ramsey/uuid-doctrine` | ^2.1    | Doctrine extension for handling UUID fields and automatically generating unique identifiers.                      |
| `vlucas/phpdotenv	`     | ^5.6    | Loads environment variables from .env files into $\_ENV, useful for separating config from code.                  |
