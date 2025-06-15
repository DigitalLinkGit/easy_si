<?php

namespace App\Capture\Entity;

use App\Capture\Repository\QuizCaptureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Capture\Enum\CaptureElementTypeEnum;
use Doctrine\Common\Collections\Collection;
use App\Capture\Interface\RenderableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizCaptureRepository::class)]
class QuizCapture extends CaptureElement
{
    /**
     * @var Collection<int, Question>
     */
    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Question::class, cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function getInterpolableVariables(): array
    {
        $questionVariables = array_map(
            fn(Question $q) => $q->getName(),
            $this->getQuestions()->toArray()
        );

        $resultVariables = array_map(
            fn(RenderResult $r) => $r->getName(),
            $this->getResults()->toArray()
        );

        return array_merge($questionVariables, $resultVariables);
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    public function getRenderable(): ?RenderableInterface
    {
        return new \App\Capture\Entity\QuizCaptureRenderer($this);
    }

    public function getType(): CaptureElementTypeEnum
    {
        return CaptureElementTypeEnum::QUIZ;
    }

    public function getResponseData(): array
    {
        $data = [];
        foreach ($this->getQuestions() as $question) {
            $data[$question->getName()] = null;
        }
        return $data;
    }
}
