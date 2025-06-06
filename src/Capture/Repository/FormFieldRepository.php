<?php
// src/Capture/Repository/FormFieldRepository.php

namespace App\Capture\Repository;

use App\Capture\Entity\FormField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FormFieldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormField::class);
    }

    // Méthodes de recherche spécifiques à FormField si besoin
}
