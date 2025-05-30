<?php

namespace App\Capture\Entity;

use App\Capture\Repository\ConditionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConditionRepository::class)]
#[ORM\Table(name: '`condition`')]
class Condition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $proposalId = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?QuestionInstance $nextQuestionInstance = null;

    #[ORM\ManyToOne(targetEntity: QuestionInstance::class, inversedBy: 'conditions')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?QuestionInstance $questionInstance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProposalId(): ?int
    {
        return $this->proposalId;
    }

    public function setProposalId(int $proposalId): static
    {
        $this->proposalId = $proposalId;

        return $this;
    }

    public function getNextQuestionInstance(): ?QuestionInstance
    {
        return $this->nextQuestionInstance;
    }

    public function setNextQuestionInstance(?QuestionInstance $nextQuestionInstance): static
    {
        $this->nextQuestionInstance = $nextQuestionInstance;

        return $this;
    }

    public function getQuestionInstance(): ?QuestionInstance
    {
        return $this->questionInstance;
    }

    public function setQuestionInstance(?QuestionInstance $questionInstance): static
    {
        $this->questionInstance = $questionInstance;

        return $this;
    }


}
