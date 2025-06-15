<?php
namespace App\Capture\Entity;

use App\Capture\Repository\RenderResultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenderResultRepository::class)]
class RenderResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $expression;

    #[ORM\ManyToOne(targetEntity: CaptureElement::class, inversedBy: 'results')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CaptureElement $element = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function setExpression(string $expression): self
    {
        $this->expression = $expression;
        return $this;
    }

    public function getElement(): ?CaptureElement
    {
        return $this->element;
    }

    public function setElement(?CaptureElement $element): self
    {
        $this->element = $element;
        return $this;
    }
}
