<?php

namespace App\Core\Service;

use App\Core\Entity\User;
use App\Core\Entity\WordStatistic;
use App\Infrastructure\Repository\WordRepository;
use App\Infrastructure\Repository\WordStatisticRepository;

class WordChecker
{
    public function __construct(
        private readonly WordRepository $wordRepository,
        private readonly WordStatisticRepository $wordStatisticRep,
    ){
    }

    /**
     * @throws \Exception
     */
    public function checkWord(string $eng, ?string $rus, User $user): bool
    {
        if (!$rus) {
            return false;
        }

        $word = $this->wordRepository->findByEng($eng)
            ?: throw new \Exception("Не найдено слово $eng!");

        $result = $word->getRus() === $rus || in_array($rus, $word->getAdditionalRus());

        $statisticEntity = $this->wordStatisticRep->findById($user->getUserId(), $word->getWordId())
            ?: new WordStatistic(wordId: $word->getWordId(), userId: $user->getUserId());

        $statisticEntity->setLastTry(new \DateTime('now'));

        if ($result) {
            $statisticEntity->incrSuccess();
        } else {
            $statisticEntity->incrError();
        }

        $this->wordStatisticRep->save($statisticEntity);

        return $result;
    }
}