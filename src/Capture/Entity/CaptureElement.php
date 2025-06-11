<?php

namespace App\Capture\Entity;

use App\Global\Entity\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Capture\Interface\RenderableInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'quiz' => QuizCapture::class,
    'form' => FormCapture::class,
])]
abstract class CaptureElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected string $name;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $description = null;

    #[ORM\ManyToOne]
    protected ?Role $respondentRole = null;

    #[ORM\ManyToOne]
    protected ?Role $validatorRole = null;

    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $renderTemplate = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected ?string $renderTitle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    protected ?int $renderTitleLevel = null;

    #[ORM\OneToMany(mappedBy: 'element', targetEntity: RenderResult::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    protected Collection $results;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getRespondentRole(): ?Role
    {
        return $this->respondentRole;
    }

    public function setRespondentRole(?Role $role): void
    {
        $this->respondentRole = $role;
    }

    public function getValidatorRole(): ?Role
    {
        return $this->validatorRole;
    }

    public function setValidatorRole(?Role $role): void
    {
        $this->validatorRole = $role;
    }

    public function getRenderTemplate(): ?string
    {
        return $this->renderTemplate;
    }

    public function setRenderTemplate(?string $renderTemplate): void
    {
        $this->renderTemplate = $renderTemplate;
    }

    public function getRenderTitle(): ?string
    {
        return $this->renderTitle;
    }

    public function setRenderTitle(?string $renderTitle): void
    {
        $this->renderTitle = $renderTitle;
    }

    public function getRenderTitleLevel(): ?int
    {
        return $this->renderTitleLevel;
    }

    public function setRenderTitleLevel(?int $renderTitleLevel): void
    {
        $this->renderTitleLevel = $renderTitleLevel;
    }



    abstract public function getInterpolableVariables(): array;

    abstract protected function getRenderable(): ?RenderableInterface;

    public function render(array $context): string
    {
        foreach ($this->getResults() as $result) {
            $evaluated = $this->evaluateExpression($result->getExpression(), $context);
            $context[$result->getName()] = $evaluated;
        }
        return $this->getRenderable()?->render($context) ?? '';
    }

    public function getResults(): Collection
    {
        return $this->results;
    }

    public function setResults(iterable $results): self
    {
        $this->results = new ArrayCollection();

        foreach ($results as $result) {
            $this->addResult($result); // si tu as une méthode addResult()
        }

        return $this;
    }


    protected function evaluateExpression(string $expression, array $context): mixed
    {   /*TODO: Symfony ExpressionLanguage*/
        $evaluable = preg_replace_callback('/\[(\w+)\]/', function ($matches) use ($context) {
            $var = $matches[1];
            return $context[$var] ?? 'null';
        }, $expression);

        try {
            return eval('return ' . $evaluable . ';');
        } catch (\Throwable $e) {
            return '[erreur]';
        }
    }

    public function addResult(RenderResult $result): static
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
            $result->setElement($this);
        }

        return $this;
    }

    public function removeResult(RenderResult $result): static
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getElement() === $this) {
                $result->setElement(null);
            }
        }

        return $this;
    }

    public function getEditRouteName(): string
    {
        return match (true) {
            $this instanceof QuizCapture => 'app_quiz_edit',
            $this instanceof FormCapture => 'app_form_capture_edit',
            default => throw new \LogicException('Type de d\élément de capture non pris en charge'),
        };
    }
}
