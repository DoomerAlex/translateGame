<?php

namespace App\Core\Service;

use App\Core\Entity\User;
use App\Core\Entity\Word;
use App\Core\Entity\WordStatistic;
use App\Infrastructure\ServiceAdapter\WordGeneratorAdapter;

/**
 * Генерирует новое слово для проверки
 */
class WordGenerator
{
    public function __construct(
        private readonly WordGeneratorAdapter $wordGeneratorAdapter,
    ){}

    public function getRandomWord(User $user): Word
    {
        $result = $this->wordGeneratorAdapter->getRandomWord($user->getUserId(), WordStatistic::SUCCESS_POINT);

        return new Word(
            eng: $result['eng'],
            rus: $result['rus'],
            wordId: $result['word_id'],
            additionalData: !empty($result['additional_data']) ? json_decode($result['additional_data'], true) : null,
        );
    }
}