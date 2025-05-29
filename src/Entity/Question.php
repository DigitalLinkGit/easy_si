<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $multipleChoice = null;

    /**
     * @var Collection<int, Proposal>
     */
    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Proposal::class, cascade: ['persist', 'remove'], orphanRemoval: true, fetch: 'EAGER')]
    private Collection $proposals;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuestionInstance::class)]
    private Collection $instances;

    public function getInstances(): Collection
    {
        return $this->instances;
    }
    public function __construct()
    {
        $this->proposals = new ArrayCollection();
        $this->instances = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function isMultipleChoice(): ?bool
    {
        return $this->multipleChoice;
    }

    public function setMultipleChoice(bool $multipleChoice): static
    {
        $this->multipleChoice = $multipleChoice;

        return $this;
    }

    /**
     * @return Collection<int, Proposal>
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    public function addProposal(Proposal $proposal): static
    {
        if (!$this->proposals->contains($proposal)) {
            $this->proposals->add($proposal);
            $proposal->setQuestion($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): static
    {
        if ($this->proposals->removeElement($proposal)) {
            // set the owning side to null (unless already changed)
            if ($proposal->getQuestion() === $this) {
                $proposal->setQuestion(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
    public function getAnswerType()
    {
        if ($this->getProposals()->count() == 0) {
            return 'Ouverte';
        } else {
            if ($this->multipleChoice) {
                return 'Choix multiple';
            } else {
                return 'Choix unique';
            }
        }
    }

    public function addInstance(QuestionInstance $instance): static
    {
        if (!$this->instances->contains($instance)) {
            $this->instances->add($instance);
            $instance->setQuestion($this);
        }

        return $this;
    }

    public function removeInstance(QuestionInstance $instance): static
    {
        if ($this->instances->removeElement($instance)) {
            // set the owning side to null (unless already changed)
            if ($instance->getQuestion() === $this) {
                $instance->setQuestion(null);
            }
        }

        return $this;
    }
}
