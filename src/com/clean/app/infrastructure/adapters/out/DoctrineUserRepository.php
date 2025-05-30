<?php

namespace Infrastructure\adapters\out;

use Infrastructure\adapters\out\mapper\UserMapper;
use Application\out\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Domain\model\User;


class DoctrineUserRepository implements UserRepository
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function save(User $user): User
    {
        $entity = UserMapper::toEntity($user);

        $plain = $user->getPassword();
        $hashed = password_hash($plain, PASSWORD_ARGON2ID);

        $entity->setPassword($hashed);
        $this->em->persist($entity);
        $this->em->flush();

        return UserMapper::toUser($entity);
    }

    public function existsByEmail(string $email): bool
    {
        $qb = $this->em->createQueryBuilder()
            ->select('1')
            ->from(UserEntity::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->setMaxResults(1);

        // Si devuelve null, no existe; si hay algo, existe
        return (bool) $qb->getQuery()->getOneOrNullResult();
    }

    public function findByEmail(string $email): User
    {
        $repo = $this->em->getRepository(UserEntity::class);
        $entity = $repo->findOneBy(['email' => $email]);
        return UserMapper::toUser($entity);
    }

    public function getAll(): array
    {
        $entities = $this->em
            ->getRepository(UserEntity::class)
            ->findAll();

        return array_map(
            fn(UserEntity $e): User => UserMapper::toUser($e),
            $entities
        );
    }
}