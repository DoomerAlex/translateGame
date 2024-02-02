<?php

namespace App\Infrastructure\Repository;

use App\Core\Entity\WordStatistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WordStatistic findOneBy(array $criteria)
 */
class WordStatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordStatistic::class);
    }

    public function findById(int $userId, int $wordId): ?WordStatistic
    {
        return $this->findOneBy(['userId' => $userId, 'wordId' => $wordId]);
    }

    public function save(WordStatistic $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}