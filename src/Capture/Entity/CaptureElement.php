<?php

namespace App\Capture\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Global\Entity\Role;
#[ORM\Entity]
#[ORM\Table(name: 'capture_element')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
abstract class CaptureElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    private ?Role $respondentRole = null;

    #[ORM\ManyToOne]
    private ?Role $validatorRole = null;

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

    public function getRespondentRole(): ?Role
    {
        return $this->respondentRole;
    }

    public function setRespondentRole(?Role $role): static
    {
        $this->respondentRole = $role;
        return $this;
    }

    public function getValidatorRole(): ?Role
    {
        return $this->validatorRole;
    }

    public function setValidatorRole(?Role $role): static
    {
        $this->validatorRole = $role;
        return $this;
    }
}
