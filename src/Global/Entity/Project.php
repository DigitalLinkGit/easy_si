<?php

namespace App\Global\Entity;

use App\Global\Repository\ProjectRepository;
use App\Capture\Entity\CaptureInstance;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $status = 'draft';

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: CaptureInstance::class)]
    private Collection $captureInstances;

    public function __construct()
    {
        $this->captureInstances = new ArrayCollection();
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

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, CaptureInstance>
     */
    public function getCaptureInstances(): Collection
    {
        return $this->captureInstances;
    }

    public function addCaptureInstance(CaptureInstance $captureInstance): static
    {
        if (!$this->captureInstances->contains($captureInstance)) {
            $this->captureInstances->add($captureInstance);
            $captureInstance->setProject($this);
        }

        return $this;
    }

    public function removeCaptureInstance(CaptureInstance $captureInstance): static
    {
        if ($this->captureInstances->removeElement($captureInstance)) {
            // set the owning side to null (unless already changed)
            if ($captureInstance->getProject() === $this) {
                $captureInstance->setProject(null);
            }
        }

        return $this;
    }
}
