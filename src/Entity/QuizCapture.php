<?php

namespace App\Entity;

use App\Repository\QuizCaptureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizCaptureRepository::class)]
class QuizCapture extends CaptureElement
{
    /**
     * @var Collection<int, QuestionInstance>
     */
    #[ORM\OneToMany(targetEntity: QuestionInstance::class, mappedBy: 'quiz')]
    private Collection $questionsInstances;

    public function __construct()
    {
        $this->questionsInstances = new ArrayCollection();
    }

    /**
     * @return Collection<int, QuestionInstance>
     */
    public function getQuestionsInstances(): Collection
    {
        return $this->questionsInstances;
    }

    public function addQuestionsInstance(QuestionInstance $questionsInstance): static
    {
        if (!$this->questionsInstances->contains($questionsInstance)) {
            $this->questionsInstances->add($questionsInstance);
            $questionsInstance->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestionsInstance(QuestionInstance $questionsInstance): static
    {
        if ($this->questionsInstances->removeElement($questionsInstance)) {
            // set the owning side to null (unless already changed)
            if ($questionsInstance->getQuiz() === $this) {
                $questionsInstance->setQuiz(null);
            }
        }

        return $this;
    }
}
