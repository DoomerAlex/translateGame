<?php

namespace App\Core\Entity;

use App\Infrastructure\Repository\WordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordRepository::class)]
#[ORM\Table(name: 'word')]
final class Word
{
    public function __construct(
        #[ORM\Column(name: 'eng', type: 'string')]
        private readonly string $eng,
        #[ORM\Column(name: 'rus', type: 'string')]
        private readonly string $rus,
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(name: 'word_id', type: 'integer')]
        private readonly ?int $wordId = null,
        #[ORM\Column(name: 'additional_data', type: 'json')]
        private ?array $additionalData = null,
    ){
    }

    public function getWordId(): ?int
    {
        return $this->wordId;
    }

    public function getEng(): string
    {
        return $this->eng;
    }

    public function getRus(): string
    {
        return $this->rus;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData ?: [];
    }

    public function getAdditionalRus(): array
    {
        return $this->additionalData['rus'] ?? [];
    }

    public function addAdditionalRus(string $word): void
    {
        $this->additionalData['rus'][] = $word;
    }
}