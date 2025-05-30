<?php

namespace App\Capture\Entity;
use App\Global\Entity\Role;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ParticipantAssignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\ManyToOne]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'participantAssignments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CaptureInstance $captureInstance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;
        return $this;
    }


    public function getCaptureInstance(): ?CaptureInstance
    {
        return $this->captureInstance;
    }

    public function setCaptureInstance(?CaptureInstance $captureInstance): static
    {
        $this->captureInstance = $captureInstance;
        return $this;
    }
}
