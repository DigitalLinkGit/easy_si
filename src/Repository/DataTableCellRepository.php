<?php
// src/Repository/TableCellRepository.php

namespace App\Repository;

use App\Entity\DataTableCell;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataTableCell>
 *
 * @method TableCell|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableCell|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableCell[]    findAll()
 * @method TableCell[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataTableCellRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataTableCell::class);
    }
}
