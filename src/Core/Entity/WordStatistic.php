<?php

namespace App\Core\Entity;

use App\Infrastructure\Repository\WordStatisticRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordStatisticRepository::class)]
#[ORM\Table(name: 'word_statistic')]
class WordStatistic
{
    public const SUCCESS_POINT = 1;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(name: 'word_id', type: 'integer')]
        private readonly int $wordId,
        #[ORM\Id]
        #[ORM\Column(name: 'user_id', type: 'integer')]
        private readonly int $userId,
        #[ORM\Column(name: 'success', type: 'integer')]
        private int $success = 0,
        #[ORM\Column(name: 'error', type: 'integer')]
        private int $error = 0,
        #[ORM\Column(name: 'last_try', type: 'datetime')]
        private \DateTime $lastTry = new \DateTime('now'),
    ){
    }

    public function getWordId(): int
    {
        return $this->wordId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setSuccess(int $num): void
    {
        $this->success = $num;
    }

    public function getSuccess(): int
    {
        return $this->success;
    }

    public function setError(int $num): void
    {
        $this->error = $num;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function setLastTry(\DateTime $datetime): void
    {
        $this->lastTry = $datetime;
    }

    public function getLastTry(): \DateTime
    {
        return $this->lastTry;
    }

    public function incrSuccess(): void
    {
        $this->success += 1;
    }

    public function incrError(): void
    {
        $this->error += 1;
    }
}