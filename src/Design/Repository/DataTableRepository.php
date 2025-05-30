<?php
// src/Repository/TableRepository.php

namespace App\Design\Repository;

use App\Design\Entity\DataTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataTable>
 *
 * @method Table|null find($id, $lockMode = null, $lockVersion = null)
 * @method Table|null findOneBy(array $criteria, array $orderBy = null)
 * @method Table[]    findAll()
 * @method Table[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataTable::class);
    }
}
