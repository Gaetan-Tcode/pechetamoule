<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: DayRepository::class)]
#[ApiResource]
class Day
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'days')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Harbor $harbor = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Tide $morning = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Tide $afternoon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHarbor(): ?Harbor
    {
        return $this->harbor;
    }

    public function setHarbor(?Harbor $harbor): self
    {
        $this->harbor = $harbor;

        return $this;
    }

    public function getMorning(): ?Tide
    {
        return $this->morning;
    }

    public function setMorning(?Tide $morning): self
    {
        $this->morning = $morning;

        return $this;
    }

    public function getAfternoon(): ?Tide
    {
        return $this->afternoon;
    }

    public function setAfternoon(?Tide $afternoon): self
    {
        $this->afternoon = $afternoon;

        return $this;
    }
}
