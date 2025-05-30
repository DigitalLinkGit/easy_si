<?php

namespace App\Capture\Entity;
use App\Capture\Entity\ParticipantAssignment;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class CaptureInstance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Capture $capture = null;

    #[ORM\OneToMany(mappedBy: 'captureElementInst', targetEntity: CaptureElementInstance::class)]
    private Collection $captureElementInstance;

    #[ORM\OneToMany(mappedBy: 'captureElementInst', targetEntity: ParticipantAssignment::class)]
    private Collection $participantAssignments;

    public function __construct()
    {
        $this->captureElementInstance = new ArrayCollection();
        $this->participantAssignments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapture(): ?Capture
    {
        return $this->capture;
    }

    public function setCapture(?Capture $capture): static
    {
        $this->capture = $capture;
        return $this;
    }

    /**
     * @return Collection<int, CaptureElementInstance>
     */
    public function getElementInstances(): Collection
    {
        return $this->captureElementInstance;
    }

    public function addElementInstance(CaptureElementInstance $captureElementInst): static
    {
        if (!$this->captureElementInstance->contains($captureElementInst)) {
            $this->captureElementInstance->add($captureElementInst);
            $captureElementInst->setCaptureInstance($this);
        }

        return $this;
    }

    public function removeElementInstance(CaptureElementInstance $captureElementInst): static
    {
        if ($this->captureElementInstance->removeElement($captureElementInst)) {
            if ($captureElementInst->getCaptureInstance() === $this) {
                $captureElementInst->setCaptureInstance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParticipantAssignment>
     */
    public function getParticipantAssignments(): Collection
    {
        return $this->participantAssignments;
    }

    public function addParticipantAssignment(ParticipantAssignment $assignment): static
    {
        if (!$this->participantAssignments->contains($assignment)) {
            $this->participantAssignments->add($assignment);
            $assignment->setCaptureInstance($this);
        }

        return $this;
    }

    public function removeParticipantAssignment(ParticipantAssignment $assignment): static
    {
        if ($this->participantAssignments->removeElement($assignment)) {
            if ($assignment->getCaptureInstance() === $this) {
                $assignment->setCaptureInstance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CaptureElementInstance>
     */
    public function getCaptureElementInsts(): Collection
    {
        return $this->captureElementInstance;
    }

    public function addCaptureElementInstance(CaptureElementInstance $captureElementInst): static
    {
        if (!$this->captureElementInstance->contains($captureElementInst)) {
            $this->captureElementInstance->add($captureElementInst);
            $captureElementInst->setCaptureInstance($this);
        }

        return $this;
    }

    public function removeCaptureElementInstance(CaptureElementInstance $captureElementInst): static
    {
        if ($this->captureElementInstance->removeElement($captureElementInst)) {
            // set the owning side to null (unless already changed)
            if ($captureElementInst->getCaptureInstance() === $this) {
                $captureElementInst->setCaptureInstance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CaptureElementInstance>
     */
    public function getCaptureElementInstance(): Collection
    {
        return $this->captureElementInstance;
    }
}
