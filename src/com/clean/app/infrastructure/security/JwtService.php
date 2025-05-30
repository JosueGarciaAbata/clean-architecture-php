<?php

namespace Infrastructure\security;

use Domain\model\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private string $secret = 'KSKDL';
    private string $algo = 'HS256';
    private int $ttl = 3600; // 1h

    public function generate(User $user): string
    {
        $now   = time();
        $payload = [
            'iat'  => $now,
            'exp'  => $now + $this->ttl,
            'sub'  => $user->getId(),
            'email'=> $user->getEmail(),
        ];
        return JWT::encode($payload, $this->secret, $this->algo);
    }

    public function validate(string $token): ?string
    {
        try {
            $data = JWT::decode($token, new Key($this->secret, $this->algo));
            return $data->sub;
        } catch (\Exception $e) {
            return null;
        }
    }
}