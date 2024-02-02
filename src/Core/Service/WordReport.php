<?php

namespace App\Core\Service;

use App\Core\Entity\User;
use App\Core\Entity\WordStatistic;
use App\Infrastructure\ServiceAdapter\WordReportAdapter;

/**
 * Сервис для составления отчетов
 */
class WordReport
{
    public function __construct(
        private readonly WordReportAdapter $wordReportAdapter,
    ){
    }

    /**
     * Возвращает статистику по всем словам
     *
     * @throws \Exception
     */
    public function getStatisticDataByUser(User $user): array
    {
        return $this->wordReportAdapter->getStatisticDataByUser($user->getUserId());
    }

    /**
     * Возвращает количество выученных слов
     *
     * @throws \Exception
     */
    public function getSuccessCount(User $user): int
    {
        return $this->wordReportAdapter->getSuccessCount($user->getUserId(), WordStatistic::SUCCESS_POINT);
    }
}