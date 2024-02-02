<?php

namespace App\Infrastructure\Repository;

use App\Core\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Word find(int $id)
 * @method Word findOneBy(array $criteria, ?array $orderBy = null)
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

    public function findByEng(string $eng): ?Word
    {
        return $this->findOneBy(['eng' => $eng]);
    }

    public function save(Word $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}