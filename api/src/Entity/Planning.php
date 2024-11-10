<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\Confirmed;
use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
#[ApiResource]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(nullable: true, enumType: Confirmed::class)]
    private ?Confirmed $status = null;

    /**
     * @var Collection<int, UserModulePlanning>
     */
    #[ORM\OneToMany(targetEntity: UserModulePlanning::class, mappedBy: 'planning')]
    private Collection $userModulePlannings;


    public function __construct()
    {
        $this->userModulePlannings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getStatus(): ?Confirmed
    {
        return $this->status;
    }

    public function setStatus(?Confirmed $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, UserModulePlanning>
     */
    public function getUserModulePlannings(): Collection
    {
        return $this->userModulePlannings;
    }

    public function addUserModulePlanning(UserModulePlanning $userModulePlanning): static
    {
        if (!$this->userModulePlannings->contains($userModulePlanning)) {
            $this->userModulePlannings->add($userModulePlanning);
            $userModulePlanning->setPlanning($this);
        }

        return $this;
    }

    public function removeUserModulePlanning(UserModulePlanning $userModulePlanning): static
    {
        if ($this->userModulePlannings->removeElement($userModulePlanning)) {
            // set the owning side to null (unless already changed)
            if ($userModulePlanning->getPlanning() === $this) {
                $userModulePlanning->setPlanning(null);
            }
        }

        return $this;
    }

}
