<?php

namespace App\Entity;

use App\Repository\TransitionChoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransitionChoiceRepository::class)]
class TransitionChoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Transition::class, inversedBy: 'choices')]
    private ?Transition $transition = null;

    #[ORM\ManyToOne(targetEntity: Interaction::class)]
    private ?Interaction $target = null;

    #[ORM\Column(length: 100)]
    private string $label;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'order_index',nullable: true)]
    private ?int $order = null;

    // Getters / setters à compléter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

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

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getTransition(): ?Transition
    {
        return $this->transition;
    }

    public function setTransition(?Transition $transition): static
    {
        $this->transition = $transition;

        return $this;
    }

    public function getTarget(): ?Interaction
    {
        return $this->target;
    }

    public function setTarget(?Interaction $target): static
    {
        $this->target = $target;

        return $this;
    }
}
