<?php

namespace App\Global\Entity;

use App\Global\Repository\ProjectRepository;
use App\Capture\Entity\CaptureInstance;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\HasLifecycleCallbacks]
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

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: ParticipantAssignment::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $participantAssignments;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
        $this->participantAssignments = new ArrayCollection();
        $this->captureInstances = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
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

    public function getAllRolesFromCaptures(): array
    {
        $roles = [];

        foreach ($this->getCaptureInstances() as $instance) {
            $capture = $instance->getCapture();
            foreach ($capture->getAllRolesFromElements() as $role) {
                $roles[$role->getId()] = $role;
            }
        }

        return array_values($roles);
    }

    public function getParticipantAssignments(): Collection
    {
        return $this->participantAssignments;
    }

    public function addParticipantAssignment(ParticipantAssignment $assignment): self
    {
        if (!$this->participantAssignments->contains($assignment)) {
            $this->participantAssignments[] = $assignment;
            $assignment->setProject($this);
        }

        return $this;
    }

    public function removeParticipantAssignment(ParticipantAssignment $assignment): self
    {
        if ($this->participantAssignments->removeElement($assignment)) {
            if ($assignment->getProject() === $this) {
                $assignment->setProject(null);
            }
        }

        return $this;
    }

    public function getAllCaptureElementsByCaptureInstance(): array
    {
        $result = [];

        foreach ($this->getCaptureInstances() as $instance) {
            $capture = $instance->getCapture();
            $result[] = [
                'instance' => $instance,
                'elements' => $capture->getElements(),
            ];
        }

        return $result;
    }
}
