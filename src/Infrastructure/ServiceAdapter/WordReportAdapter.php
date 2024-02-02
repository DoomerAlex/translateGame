<?php

namespace App\Infrastructure\ServiceAdapter;

use Doctrine\DBAL\Connection;

class WordReportAdapter
{
    public function __construct(
        private readonly Connection $connection,
    ){
    }

    /**
     * Возвращает статистику по всем словам
     *
     * @throws \Exception
     */
    public function getStatisticDataByUser(int $userId): array
    {
        return $this->connection->executeQuery('SELECT  
        w.rus, w.eng, coalesce(ws.success, 0) as success, coalesce(ws.error, 0) as error, ws.last_try
        FROM word w 
        LEFT JOIN word_statistic ws ON w.word_id = ws.word_id
        WHERE ws.user_id = :userId OR ws.user_id IS NULL
        ', ['userId' => $userId])->fetchAllAssociative();
    }

    /**
     * Возвращает количество выученных слов
     *
     * @throws \Exception
     */
    public function getSuccessCount(int $userId, int $successPoint): int
    {
        return $this->connection->executeQuery('SELECT count(*) 
           FROM word_statistic
           WHERE user_id = :userId AND success >= :successPoint', [
            'userId' => $userId,
            'successPoint' => $successPoint,
        ])->fetchOne();
    }
}