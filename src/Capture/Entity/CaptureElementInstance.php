<?php

namespace App\Capture\Entity;

use App\Capture\Repository\CaptureElementInstanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaptureElementInstanceRepository::class)]
class CaptureElementInstance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'elementInstances')]
    private ?CaptureInstance $captureInstance = null;

    #[ORM\ManyToOne]
    private ?CaptureElement $element = null;

    #[ORM\Column(length: 255)]
    private string $respondentEmail;

    #[ORM\Column(length: 255)]
    private string $validatorEmail;

    #[ORM\Column(length: 255)]
    private string $linkToken;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $linkExpiresAt;

    #[ORM\Column(length: 50)]
    private string $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaptureInstance(): ?CaptureInstance
    {
        return $this->captureInstance;
    }

    public function setCaptureInstance(?CaptureInstance $captureInstance): static
    {
        $this->captureInstance = $captureInstance;
        return $this;
    }

    public function getElement(): ?CaptureElement
    {
        return $this->element;
    }

    public function setElement(?CaptureElement $element): static
    {
        $this->element = $element;
        return $this;
    }

    public function getRespondentEmail(): string
    {
        return $this->respondentEmail;
    }

    public function setRespondentEmail(string $respondentEmail): static
    {
        $this->respondentEmail = $respondentEmail;
        return $this;
    }

    public function getValidatorEmail(): string
    {
        return $this->validatorEmail;
    }

    public function setValidatorEmail(string $validatorEmail): static
    {
        $this->validatorEmail = $validatorEmail;
        return $this;
    }

    public function getLinkToken(): string
    {
        return $this->linkToken;
    }

    public function setLinkToken(string $linkToken): static
    {
        $this->linkToken = $linkToken;
        return $this;
    }

    public function getLinkExpiresAt(): \DateTimeInterface
    {
        return $this->linkExpiresAt;
    }

    public function setLinkExpiresAt(\DateTimeInterface $linkExpiresAt): static
    {
        $this->linkExpiresAt = $linkExpiresAt;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }
}
