<?php

namespace App\Infrastructure\ServiceAdapter;

use Doctrine\DBAL\Connection;

class WordGeneratorAdapter
{
    public function __construct(
        private readonly Connection $connection,
    ){
    }

    public function getRandomWord(int $userId, int $successPoint): array
    {
        return $this->connection->executeQuery('SELECT w.* FROM word w 
           LEFT JOIN word_statistic ws ON w.word_id = ws.word_id
           WHERE ws.success < :successPoint OR ws.success is NULL 
           ORDER BY random() LIMIT 1
        ', [
            'successPoint' => $successPoint,
        ])->fetchAssociative();
    }
}