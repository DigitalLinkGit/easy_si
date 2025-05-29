<?php
namespace App\Repository;

use App\Entity\CaptureElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CaptureElement>
 *
 * @method CaptureElement|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaptureElement|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaptureElement[]    findAll()
 * @method CaptureElement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaptureElementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaptureElement::class);
    }

    // Add custom methods here if needed
}
