# clean-architecture-php
Practice with clean architecture (hexagonal) to gain a stronger foundation in concepts such as IoC, ports, interfaces, adapters, etc.

Este proyecto PHP utiliza Composer para gestionar sus paquetes. Ejecuta:
composer install

**Base de datos:** PostgreSQL

| Paquete                    | Versión | Descripción                                                                                     |
|----------------------------|---------|-------------------------------------------------------------------------------------------------|
| `php-di/php-di`            | ^7.0    | Contenedor de inversión de control (IoC) y DI, resuelve automáticamente clases y sus dependencias. |
| `doctrine/orm`             | ^3.3    | ORM para mapear objetos a tablas de base de datos y trabajar con entidades y repositorios.       |
| `rekalogika/mapper`        | ^2.0    | Utilidad para mapear propiedades entre objetos (ideal para DTOs y entidades).                    |
| `firebase/php-jwt`         | ^6.11   | Generación y validación de JSON Web Tokens (JWT) para autenticación basada en tokens.            |
| `psr/http-message`         | *       | Interfaces PSR-7 estándar para representar peticiones y respuestas HTTP.                         |
| `slim/slim`                | 4.*     | Micro-framework para crear APIs y aplicaciones web ligeras.                                       |
| `slim/psr7`                | *       | Implementación PSR-7 usada internamente por Slim para mensajes HTTP.                             |
| `php-di/slim-bridge`       | *       | Integración entre PHP-DI y Slim: permite inyección de dependencias en controladores y middleware. |
| `ramsey/uuid-doctrine`     | ^2.1    | Extensión Doctrine para manejar campos UUID y generar identificadores únicos automáticamente.     |
