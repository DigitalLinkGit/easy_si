<?php

namespace App\Design\Entity;

use App\Design\Repository\TransformationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransformationRepository::class)]
class Transformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: DataTable::class)]
    private ?DataTable $sourceTable = null;

    #[ORM\ManyToOne(targetEntity: DataTable::class)]
    private ?DataTable $targetTable = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $sourceKeyColumn = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $targetKeyColumn = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $transformationRules = null;

    // Getters / setters à compléter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceKeyColumn(): ?string
    {
        return $this->sourceKeyColumn;
    }

    public function setSourceKeyColumn(?string $sourceKeyColumn): static
    {
        $this->sourceKeyColumn = $sourceKeyColumn;

        return $this;
    }

    public function getTargetKeyColumn(): ?string
    {
        return $this->targetKeyColumn;
    }

    public function setTargetKeyColumn(?string $targetKeyColumn): static
    {
        $this->targetKeyColumn = $targetKeyColumn;

        return $this;
    }

    public function getTransformationRules(): ?string
    {
        return $this->transformationRules;
    }

    public function setTransformationRules(?string $transformationRules): static
    {
        $this->transformationRules = $transformationRules;

        return $this;
    }

    public function getSourceTable(): ?DataTable
    {
        return $this->sourceTable;
    }

    public function setSourceTable(?DataTable $sourceTable): static
    {
        $this->sourceTable = $sourceTable;

        return $this;
    }

    public function getTargetTable(): ?DataTable
    {
        return $this->targetTable;
    }

    public function setTargetTable(?DataTable $targetTable): static
    {
        $this->targetTable = $targetTable;

        return $this;
    }
}

