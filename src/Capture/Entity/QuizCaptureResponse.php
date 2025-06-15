<?php

namespace App\Capture\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizCaptureResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'json')]
    private array $answers = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): static
    {
        $this->answers = $answers;
        return $this;
    }
}
