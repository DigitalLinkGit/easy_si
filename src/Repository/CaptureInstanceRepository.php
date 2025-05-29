<?php
namespace App\Repository;

use App\Entity\CaptureInstance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CaptureInstance>
 *
 * @method CaptureInstance|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaptureInstance|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaptureInstance[]    findAll()
 * @method CaptureInstance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaptureInstanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaptureInstance::class);
    }

    // Add custom methods here if needed
}
