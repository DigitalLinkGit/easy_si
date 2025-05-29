<?php

namespace App\Entity;

use App\Repository\TransitionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: TransitionRepository::class)]
class Transition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Interaction::class, inversedBy: 'transitionsFrom')]
    private ?Interaction $from = null;

    #[ORM\Column(length: 20)]
    private string $type; // direct, mapping, condition, loop, end

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'order_index',nullable: true)]
    private ?int $order = null;

    #[ORM\OneToOne(targetEntity: Transformation::class, cascade: ['persist', 'remove'])]
    private ?Transformation $transformation = null;

    #[ORM\OneToMany(mappedBy: 'transition', targetEntity: TransitionChoice::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $choices;

    public function __construct()
    {
        $this->choices = new ArrayCollection();
    }

    // Getters / setters à compléter

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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
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

    public function getFrom(): ?Interaction
    {
        return $this->from;
    }

    public function setFrom(?Interaction $from): static
    {
        $this->from = $from;

        return $this;
    }

    public function getTransformation(): ?Transformation
    {
        return $this->transformation;
    }

    public function setTransformation(?Transformation $transformation): static
    {
        $this->transformation = $transformation;

        return $this;
    }

    /**
     * @return Collection<int, TransitionChoice>
     */
    public function getChoices(): Collection
    {
        return $this->choices;
    }

    public function addChoice(TransitionChoice $choice): static
    {
        if (!$this->choices->contains($choice)) {
            $this->choices->add($choice);
            $choice->setTransition($this);
        }

        return $this;
    }

    public function removeChoice(TransitionChoice $choice): static
    {
        if ($this->choices->removeElement($choice)) {
            // set the owning side to null (unless already changed)
            if ($choice->getTransition() === $this) {
                $choice->setTransition(null);
            }
        }

        return $this;
    }
}
