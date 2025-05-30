<?php

namespace App\Design\Entity;

use App\Design\Repository\DataTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataTableRepository::class)]
class DataTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'dataTables')]
    private ?Service $service = null;

    #[ORM\OneToMany(mappedBy: 'table', targetEntity: DataTableCell::class, cascade: ['persist', 'remove'])]
    private Collection $cells;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, DataTableCell>
     */
    public function getCells(): Collection
    {
        return $this->cells;
    }

    public function addCell(DataTableCell $cell): static
    {
        if (!$this->cells->contains($cell)) {
            $this->cells->add($cell);
            $cell->setTable($this);
        }

        return $this;
    }

    public function removeCell(DataTableCell $cell): static
    {
        if ($this->cells->removeElement($cell)) {
            // set the owning side to null (unless already changed)
            if ($cell->getTable() === $this) {
                $cell->setTable(null);
            }
        }

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }
}
