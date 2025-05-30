<?php

namespace App\Capture\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Capture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: CaptureElement::class)]
    #[ORM\JoinTable(name: 'capture_elements')]
    private Collection $elements;

    #[ORM\ManyToMany(targetEntity: Role::class)]
    private Collection $requiredRoles;

    public function __construct()
    {
        $this->elements = new ArrayCollection();
        $this->requiredRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
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
     * @return Collection<int, CaptureElement>
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    public function removeElement(CaptureElement $element): static
    {
        $this->elements->removeElement($element);
        return $this;
    }

    public function addElement(CaptureElement $element): static
    {
        if (!$this->elements->contains($element)) {
            $this->elements->add($element);

            // Ajout des rôles nécessaires
            if ($element->getRespondentRole()) {
                $this->addRequiredRole($element->getRespondentRole());
            }
            if ($element->getValidatorRole()) {
                $this->addRequiredRole($element->getValidatorRole());
            }
        }

        return $this;
    }

    public function addRequiredRole(Role $role): static
    {
        if (!$this->requiredRoles->contains($role)) {
            $this->requiredRoles->add($role);
        }

        return $this;
    }

    public function getAllRolesFromElements(): array
    {
        $roles = [];

        foreach ($this->getElements() as $element) {
            $respondentRole = $element->getRespondentRole();
            $validatorRole = $element->getValidatorRole();

            if ($respondentRole instanceof \App\Capture\Entity\Role) {
                $roles[$respondentRole->getId()] = $respondentRole;
            }

            if ($validatorRole instanceof \App\Capture\Entity\Role) {
                $roles[$validatorRole->getId()] = $validatorRole;
            }
        }

        return array_values($roles);
    }
}
