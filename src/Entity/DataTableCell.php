<?php
// src/Entity/DataTableCell.php

namespace App\Entity;

use App\Repository\DataTableCellRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataTableCellRepository::class)]
class DataTableCell
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: DataTable::class, inversedBy: 'cells')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DataTable $table = null;

    #[ORM\Column(type: 'integer')]
    private int $rowIndex;

    #[ORM\Column(type: 'integer')]
    private int $colIndex;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $columnName = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataTable(): ?DataTable
    {
        return $this->table;
    }

    public function setDataTable(?DataTable $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function getRowIndex(): int
    {
        return $this->rowIndex;
    }

    public function setRowIndex(int $rowIndex): self
    {
        $this->rowIndex = $rowIndex;
        return $this;
    }

    public function getColIndex(): int
    {
        return $this->colIndex;
    }

    public function setColIndex(int $colIndex): self
    {
        $this->colIndex = $colIndex;
        return $this;
    }

    public function getColumnName(): ?string
    {
        return $this->columnName;
    }

    public function setColumnName(?string $columnName): self
    {
        $this->columnName = $columnName;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getTable(): ?DataTable
    {
        return $this->table;
    }

    public function setTable(?DataTable $table): static
    {
        $this->table = $table;

        return $this;
    }
}
