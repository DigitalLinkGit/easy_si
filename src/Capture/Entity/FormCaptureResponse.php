<?php

namespace App\Capture\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class FormCaptureResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'json')]
    private array $values = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function setValues(array $values): static
    {
        $this->values = $values;
        return $this;
    }
}
