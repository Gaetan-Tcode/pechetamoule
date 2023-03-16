<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TideRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TideRepository::class)]
#[ApiResource]
class Tide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?float $highHeight = null;

    #[ORM\Column]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?float $lowHeight = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?\DateTimeInterface $highHour = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?\DateTimeInterface $lowHour = null;

    #[ORM\Column]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?float $coefficient = null;

    #[ORM\ManyToOne(inversedBy: 'tides')]
    private ?Harbor $harbor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHighHeight(): ?float
    {
        return $this->highHeight;
    }

    public function setHighHeight(float $highHeight): self
    {
        $this->highHeight = $highHeight;

        return $this;
    }

    public function getLowHeight(): ?float
    {
        return $this->lowHeight;
    }

    public function setLowHeight(float $lowHeight): self
    {
        $this->lowHeight = $lowHeight;

        return $this;
    }

    public function getHighHour(): ?\DateTimeInterface
    {
        return $this->highHour;
    }

    public function setHighHour(\DateTimeInterface $highHour): self
    {
        $this->highHour = $highHour;

        return $this;
    }

    public function getLowHour(): ?\DateTimeInterface
    {
        return $this->lowHour;
    }

    public function setLowHour(\DateTimeInterface $lowHour): self
    {
        $this->lowHour = $lowHour;

        return $this;
    }

    public function getCoefficient(): ?float
    {
        return $this->coefficient;
    }

    public function setCoefficient(float $coefficient): self
    {
        $this->coefficient = $coefficient;

        return $this;
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
}
