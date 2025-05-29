<?php

namespace App\Entity;

use App\Repository\TutorialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TutorialRepository::class)]
class Tutorial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $route = null;

    /**
     * @var Collection<int, TutorialStep>
     */
    #[ORM\OneToMany(mappedBy: 'tutorial', targetEntity: TutorialStep::class, cascade: ['persist', 'remove'], orphanRemoval: true, fetch: 'EAGER')]
    #[ORM\OrderBy(['number' => 'ASC'])]
    private Collection $steps;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
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

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(?string $route): static
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return Collection<int, TutorialStep>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(TutorialStep $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setTutorial($this);
        }

        return $this;
    }

    public function removeStep(TutorialStep $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getTutorial() === $this) {
                $step->setTutorial(null);
            }
        }

        return $this;
    }
}
