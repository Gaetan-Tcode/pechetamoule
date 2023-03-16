<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\HarborRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HarborRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'harbor:item']),
        new GetCollection(normalizationContext: ['groups' => 'harbor:list'])
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class Harbor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?string $latitude = null;

    #[ORM\Column(length: 255)]
    #[Groups(['harbor:item', 'harbor:list'])]
    private ?string $longitude = null;

    #[ORM\OneToMany(mappedBy: 'harbor', targetEntity: Tide::class)]
    #[Groups(['harbor:item', 'harbor:list'])]
    
    private Collection $tides;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Department = null;

    public function __construct()
    {
        $this->days = new ArrayCollection();
        $this->tides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $lat): self
    {
        $this->latitude = $lat;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, Tide>
     */
    public function getTides(): Collection
    {
        return $this->tides;
    }

    public function addTide(Tide $tide): self
    {
        if (!$this->tides->contains($tide)) {
            $this->tides->add($tide);
            $tide->setHarbor($this);
        }

        return $this;
    }

    public function removeTide(Tide $tide): self
    {
        if ($this->tides->removeElement($tide)) {
            // set the owning side to null (unless already changed)
            if ($tide->getHarbor() === $this) {
                $tide->setHarbor(null);
            }
        }

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->Department;
    }

    public function setDepartment(?string $Department): self
    {
        $this->Department = $Department;

        return $this;
    }
}
