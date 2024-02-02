<?php

namespace App\Core\Entity;

use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(name: 'user_id', type: 'integer')]
        private ?int $userId = null,
        #[ORM\Column(name: 'name', type: 'string')]
        private ?string $name = null,
    ){
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}