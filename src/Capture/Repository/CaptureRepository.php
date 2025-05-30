<?php
namespace App\Capture\Repository;

use App\Capture\Entity\Capture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Capture>
 *
 * @method Capture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capture[]    findAll()
 * @method Capture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaptureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Capture::class);
    }

    // Add custom methods here if needed
}
