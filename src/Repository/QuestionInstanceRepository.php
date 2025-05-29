<?php

namespace App\Repository;

use App\Entity\QuestionInstance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionInstance>
 */
class QuestionInstanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionInstance::class);
    }

    public function countByLevel(int $level, int $sectionId): int
    {
        return $this->createQueryBuilder('qi')
            ->select('COUNT(qi.id)')
            ->where('qi.level = :level')
            ->andWhere('qi.section = :section')
            ->setParameter('level', $level)
            ->setParameter('section', $sectionId)
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function countProposalsForSingleChoiceAtLevelInSection(int $level, int $sectionId): int
    {
        return (int) $this->createQueryBuilder('qi')
            ->select('COUNT(p.id)')
            ->join('qi.question', 'q')
            ->join('q.proposals', 'p')
            ->where('qi.level = :level')
            ->andWhere('q.multipleChoice = false')
            ->andWhere('qi.section = :section')
            ->setParameter('level', $level)
            ->setParameter('section', $sectionId)
            ->getQuery()
            ->getSingleScalarResult();
    }





    //    /**
    //     * @return QuestionInstance[] Returns an array of QuestionInstance objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?QuestionInstance
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
