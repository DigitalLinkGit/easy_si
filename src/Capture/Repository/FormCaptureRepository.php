<?php
// src/Capture/Repository/FormCaptureRepository.php

namespace App\Capture\Repository;

use App\Capture\Entity\FormCapture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FormCaptureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormCapture::class);
    }

    // Ajoute ici des méthodes personnalisées si besoin
}
