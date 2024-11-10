<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\Confirmed;
use App\Enum\CourseMode;
use App\Repository\UserModulePlanningRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserModulePlanningRepository::class)]
#[ApiResource]
class UserModulePlanning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true, enumType: Confirmed::class)]
    private ?Confirmed $status = null;

    #[ORM\Column(nullable: true, enumType: CourseMode::class)]
    private ?CourseMode $location = null;

    #[ORM\ManyToOne(inversedBy: 'userModulePlannings')]
    private ?Module $module = null;

    #[ORM\ManyToOne(inversedBy: 'userModulePlannings')]
    private ?User $userTeacher = null;

    #[ORM\ManyToOne(inversedBy: 'userModulePlannings')]
    private ?Planning $planning = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?Confirmed
    {
        return $this->status;
    }

    public function setStatus(Confirmed $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getLocation(): ?CourseMode
    {
        return $this->location;
    }

    public function setLocation(?CourseMode $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }

    public function getUserTeacher(): ?User
    {
        return $this->userTeacher;
    }

    public function setUserTeacher(?User $userTeacher): static
    {
        $this->userTeacher = $userTeacher;

        return $this;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlanning(?Planning $planning): static
    {
        $this->planning = $planning;

        return $this;
    }

}
