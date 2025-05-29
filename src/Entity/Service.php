<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null; // rest, soap, file, etc.

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $endpoint = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $authMethod = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $method = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $format = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $direction = null;

    #[ORM\ManyToOne]
    private ?Element $element = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: DataTable::class)]
    private Collection $dataTables;

    public function __construct()
    {
        $this->dataTables = new ArrayCollection();
    }

    // ... GETTERS & SETTERS ...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
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

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function setEndpoint(?string $endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getAuthMethod(): ?string
    {
        return $this->authMethod;
    }

    public function setAuthMethod(?string $authMethod): static
    {
        $this->authMethod = $authMethod;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method): static
    {
        $this->method = $method;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(?string $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function getElement(): ?Element
    {
        return $this->element;
    }

    public function setElement(?Element $element): static
    {
        $this->element = $element;

        return $this;
    }

    /**
     * @return Collection<int, DataTable>
     */
    public function getDataTables(): Collection
    {
        return $this->dataTables;
    }

    public function addDataTable(DataTable $dataTable): static
    {
        if (!$this->dataTables->contains($dataTable)) {
            $this->dataTables->add($dataTable);
            $dataTable->setService($this);
        }

        return $this;
    }

    public function removeDataTable(DataTable $dataTable): static
    {
        if ($this->dataTables->removeElement($dataTable)) {
            // set the owning side to null (unless already changed)
            if ($dataTable->getService() === $this) {
                $dataTable->setService(null);
            }
        }

        return $this;
    }
}
