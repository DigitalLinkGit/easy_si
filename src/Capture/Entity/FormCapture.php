<?php
// src/Capture/Entity/FormCapture.php

namespace App\Capture\Entity;

use App\Capture\Repository\FormCaptureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Capture\Interface\RenderableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormCaptureRepository::class)]
class FormCapture extends CaptureElement
{

    #[ORM\OneToMany(mappedBy: 'formCapture', targetEntity: FormField::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $fields;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }
    public function getFormFieldsSorted(): array
    {
        $fields = $this->fields->toArray();
        usort($fields, fn($a, $b) => $a->getPosition() <=> $b->getPosition());
        return $fields;
    }

    /**
     * @return Collection<int, FormField>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(FormField $field): static
    {
        if (!$this->fields->contains($field)) {
            $this->fields->add($field);
            $field->setFormCapture($this);
        }

        return $this;
    }

    public function removeField(FormField $field): static
    {
        if ($this->fields->removeElement($field)) {
            // set the owning side to null (unless already changed)
            if ($field->getFormCapture() === $this) {
                $field->setFormCapture(null);
            }
        }

        return $this;
    }

    public function getInterpolableVariables(): array
    {
        $variables = array_map(
            fn(FormField $f) => $f->getName(),
            $this->getFields()->toArray()
        );

        $results = array_map(
            fn(RenderResult $r) => $r->getName(),
            $this->getResults()->toArray()
        );

        return array_merge($variables, $results);
    }


    public function getRenderable(): ?RenderableInterface
    {
        return new \App\Capture\Entity\FormCaptureRenderer($this);
    }

}
