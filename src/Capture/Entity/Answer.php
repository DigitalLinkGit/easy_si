<?php

namespace App\Capture\Entity;

use App\Capture\Enum\AnswerType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: QuestionInstance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private QuestionInstance $questionInstance;

    #[ORM\Column(type: 'string', enumType: AnswerType::class)]
    private AnswerType $type;

    // Champs optionnels selon le type de réponse
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $textValue = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $numericValue = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dateValue = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $boolValue = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $choiceValues = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?AnswerType
    {
        return $this->type;
    }

    public function setType(AnswerType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTextValue(): ?string
    {
        return $this->textValue;
    }

    public function setTextValue(?string $textValue): static
    {
        $this->textValue = $textValue;

        return $this;
    }

    public function getNumericValue(): ?float
    {
        return $this->numericValue;
    }

    public function setNumericValue(?float $numericValue): static
    {
        $this->numericValue = $numericValue;

        return $this;
    }

    public function getDateValue(): ?\DateTime
    {
        return $this->dateValue;
    }

    public function setDateValue(?\DateTime $dateValue): static
    {
        $this->dateValue = $dateValue;

        return $this;
    }

    public function isBoolValue(): ?bool
    {
        return $this->boolValue;
    }

    public function setBoolValue(?bool $boolValue): static
    {
        $this->boolValue = $boolValue;

        return $this;
    }

    public function getChoiceValues(): ?array
    {
        return $this->choiceValues;
    }

    public function setChoiceValues(?array $choiceValues): static
    {
        $this->choiceValues = $choiceValues;

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
    public function getValue(): mixed
    {
        return match ($this->type) {
            AnswerType::TEXT => $this->textValue,
            AnswerType::NUMBER => $this->numericValue,
            AnswerType::DATE => $this->dateValue,
            AnswerType::BOOLEAN => $this->boolValue,
            AnswerType::SINGLE_CHOICE, AnswerType::MULTI_CHOICE => $this->choiceValues,
        };
    }
}
