<?php

namespace App\Capture\Entity;

use App\Capture\Repository\QuestionInstanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionInstanceRepository::class)]
class QuestionInstance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'previous_question_instance_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    private ?self $previousQuestionInstance = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'next_question_instance_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    private ?self $nextQuestionInstance = null;

    /**
     * @var Collection<int, Condition>
     */
    #[ORM\OneToMany(mappedBy: 'questionInstance', targetEntity: Condition::class, cascade: ['persist', 'remove'], orphanRemoval: true, fetch: 'EAGER')]
    private Collection $conditions;

    #[ORM\ManyToOne(inversedBy: 'instances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'questionsInstances')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?QuizCapture $quiz = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $renderTemplate = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $renderTitleLevel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $renderTitle = null;

    public function __construct()
    {
        $this->conditions = new ArrayCollection();
        $this->level = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPreviousQuestionInstance(): ?self
    {
        return $this->previousQuestionInstance;
    }

    public function setPreviousQuestionInstance(?self $previousQuestionInstance): static
    {
        $this->previousQuestionInstance = $previousQuestionInstance;
        return $this;
    }

    public function getNextQuestionInstance(): ?self
    {
        return $this->nextQuestionInstance;
    }

    public function setNextQuestionInstance(?self $nextQuestionInstance): static
    {
        $this->nextQuestionInstance = $nextQuestionInstance;
        return $this;
    }

    public function removeNextQuestionInstance()
    {
        $this->nextQuestionInstance = null;
    }

    /**
     * @return Collection<int, Condition>
     */
    public function getConditions(): Collection
    {
        return $this->conditions;
    }

    public function addCondition(Condition $condition): static
    {
        if (!$this->conditions->contains($condition)) {
            $this->conditions->add($condition);
            $condition->setQuestionInstance($this);
        }

        return $this;
    }

    public function removeCondition(Condition $condition): static
    {
        if ($this->conditions->removeElement($condition)) {
            if ($condition->getQuestionInstance() === $this) {
                $condition->setQuestionInstance(null);
            }
        }

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;
        return $this;
    }

    public function getQuiz(): ?QuizCapture
    {
        return $this->quiz;
    }

    public function setQuiz(?QuizCapture $quiz): static
    {
        $this->quiz = $quiz;
        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;
        return $this;
    }

    public function getConditionByProposalId(int $proposalId): ?Condition
    {
        foreach ($this->getConditions() as $condition) {
            if ($condition->getProposalId() === $proposalId) {
                return $condition;
            }
        }

        return null;
    }

    public function getNumberOfQuestionsAtSameLevel(QuestionInstanceRepository $repo): int
    {
        return $repo->countByLevel($this->getLevel(), $this->getQuiz()->getId());
    }

    public function getNumberOfConditionableAtSameLevel(QuestionInstanceRepository $repo): int
    {
        return $repo->countProposalsForSingleChoiceAtLevelInQuiz($this->getLevel(), $this->getQuiz()->getId());
    }

    public function removeConditionByProposalId(int $proposalId): void
    {
        foreach ($this->conditions as $key => $condition) {
            if ($condition->getProposalId() === $proposalId) {
                $this->conditions->remove($key);
                $condition->setQuestionInstance(null);
            }
        }
    }

    public function getRenderTemplate(): ?string
    {
        return $this->renderTemplate;
    }

    public function setRenderTemplate(?string $renderTemplate): self
    {
        $this->renderTemplate = $renderTemplate;
        return $this;
    }

    public function render(array $context = []): string
    {
        if (empty($this->renderTemplate)) {
            return '';
        }

        $template = $this->renderTemplate;

        foreach ($context as $key => $value) {
            $template = str_replace("[$key]", $value, $template);
        }
        return $template;
    }

    public function getRenderTitle(): ?string
    {
        return $this->renderTitle;
    }

    public function setRenderTitle(?string $renderTitle): self
    {
        $this->renderTitle = $renderTitle;
        return $this;
    }

    public function getRenderTitleLevel(): ?string
    {
        return $this->renderTitleLevel;
    }

    public function setRenderTitleLevel(?string $renderTitleLevel): self
    {
        $this->renderTitleLevel = $renderTitleLevel;
        return $this;
    }
}
