<?php

namespace App\Design\Entity;

use App\Design\Repository\InteractionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InteractionRepository::class)]
class Interaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $dataName = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Element::class)]
    private ?Element $elementIn = null;

    #[ORM\ManyToOne(targetEntity: Element::class)]
    private ?Element $elementOut = null;

    #[ORM\ManyToOne(targetEntity: Flow::class, inversedBy: 'interactions')]
    private ?Flow $flow = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $logic = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isConditional = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $conditionLabel = null;

    #[ORM\OneToMany(mappedBy: 'from', targetEntity: Transition::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $transitionsFrom;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    private ?Service $serviceIn = null;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    private ?Service $serviceOut = null;

    public function __construct()
    {
        $this->transitionsFrom = new ArrayCollection();
    }

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

    public function getDataName(): ?string
    {
        return $this->dataName;
    }

    public function setDataName(string $dataName): static
    {
        $this->dataName = $dataName;
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

    public function getElementIn(): ?Element
    {
        return $this->elementIn;
    }

    public function setElementIn(?Element $elementIn): static
    {
        $this->elementIn = $elementIn;
        return $this;
    }

    public function getElementOut(): ?Element
    {
        return $this->elementOut;
    }

    public function setElementOut(?Element $elementOut): static
    {
        $this->elementOut = $elementOut;
        return $this;
    }

    public function getFlow(): ?Flow
    {
        return $this->flow;
    }

    public function setFlow(?Flow $flow): static
    {
        $this->flow = $flow;
        return $this;
    }

    public function getLogic(): ?array
    {
        return $this->logic;
    }

    public function setLogic(?array $logic): static
    {
        $this->logic = $logic;
        return $this;
    }

    public function isConditional(): bool
    {
        return $this->isConditional;
    }

    public function setIsConditional(bool $isConditional): static
    {
        $this->isConditional = $isConditional;
        return $this;
    }

    public function getConditionLabel(): ?string
    {
        return $this->conditionLabel;
    }

    public function setConditionLabel(?string $conditionLabel): static
    {
        $this->conditionLabel = $conditionLabel;
        return $this;
    }

    /**
     * @return Collection<int, Transition>
     */
    public function getTransitionsFrom(): Collection
    {
        return $this->transitionsFrom;
    }

    public function addTransitionFrom(Transition $transition): static
    {
        if (!$this->transitionsFrom->contains($transition)) {
            $this->transitionsFrom->add($transition);
            $transition->setFrom($this);
        }

        return $this;
    }

    public function removeTransitionFrom(Transition $transition): static
    {
        if ($this->transitionsFrom->removeElement($transition)) {
            if ($transition->getFrom() === $this) {
                $transition->setFrom(null);
            }
        }

        return $this;
    }

    public function getServiceIn(): ?Service
    {
        return $this->serviceIn;
    }

    public function setServiceIn(?Service $serviceIn): static
    {
        $this->serviceIn = $serviceIn;
        return $this;
    }
    public function getServiceOut(): ?Service
    {
        return $this->serviceOut;
    }

    public function setServiceOut(?Service $serviceOut): static
    {
        $this->serviceOut = $serviceOut;
        return $this;
    }

    public function addTransitionsFrom(Transition $transitionsFrom): static
    {
        if (!$this->transitionsFrom->contains($transitionsFrom)) {
            $this->transitionsFrom->add($transitionsFrom);
            $transitionsFrom->setFrom($this);
        }

        return $this;
    }

    public function removeTransitionsFrom(Transition $transitionsFrom): static
    {
        if ($this->transitionsFrom->removeElement($transitionsFrom)) {
            // set the owning side to null (unless already changed)
            if ($transitionsFrom->getFrom() === $this) {
                $transitionsFrom->setFrom(null);
            }
        }

        return $this;
    }
}
