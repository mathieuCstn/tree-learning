<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?array $roles = null;

    /**
     * @var Collection<int, Degree>
     */
    #[ORM\ManyToMany(targetEntity: Degree::class, inversedBy: 'users')]
    private Collection $degrees;

    /**
     * @var Collection<int, Address>
     */
    #[ORM\OneToMany(targetEntity: Address::class, mappedBy: 'userAccount')]
    private Collection $addresses;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'users')]
    private Collection $skills;

    /**
     * @var Collection<int, UserModulePlanning>
     */
    #[ORM\OneToMany(targetEntity: UserModulePlanning::class, mappedBy: 'userTeacher')]
    private Collection $userModulePlannings;

    /**
     * @var Collection<int, Raiting>
     */
    #[ORM\OneToMany(targetEntity: Raiting::class, mappedBy: 'supervisor')]
    private Collection $raitings;

    /**
     * @var Collection<int, AssessmentSession>
     */
    #[ORM\OneToMany(targetEntity: AssessmentSession::class, mappedBy: 'userAccount')]
    private Collection $assessmentSessions;

    public function __construct()
    {
        $this->degrees = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->userModulePlannings = new ArrayCollection();
        $this->raitings = new ArrayCollection();
        $this->assessmentSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Degree>
     */
    public function getDegrees(): Collection
    {
        return $this->degrees;
    }

    public function addDegree(Degree $degree): static
    {
        if (!$this->degrees->contains($degree)) {
            $this->degrees->add($degree);
        }

        return $this;
    }

    public function removeDegree(Degree $degree): static
    {
        $this->degrees->removeElement($degree);

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->setUserAccount($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUserAccount() === $this) {
                $address->setUserAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        $this->skills->removeElement($skill);

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
            $userModulePlanning->setUserTeacher($this);
        }

        return $this;
    }

    public function removeUserModulePlanning(UserModulePlanning $userModulePlanning): static
    {
        if ($this->userModulePlannings->removeElement($userModulePlanning)) {
            // set the owning side to null (unless already changed)
            if ($userModulePlanning->getUserTeacher() === $this) {
                $userModulePlanning->setUserTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Raiting>
     */
    public function getRaitings(): Collection
    {
        return $this->raitings;
    }

    public function addRaiting(Raiting $raiting): static
    {
        if (!$this->raitings->contains($raiting)) {
            $this->raitings->add($raiting);
            $raiting->setSupervisor($this);
        }

        return $this;
    }

    public function removeRaiting(Raiting $raiting): static
    {
        if ($this->raitings->removeElement($raiting)) {
            // set the owning side to null (unless already changed)
            if ($raiting->getSupervisor() === $this) {
                $raiting->setSupervisor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AssessmentSession>
     */
    public function getAssessmentSessions(): Collection
    {
        return $this->assessmentSessions;
    }

    public function addAssessmentSession(AssessmentSession $assessmentSession): static
    {
        if (!$this->assessmentSessions->contains($assessmentSession)) {
            $this->assessmentSessions->add($assessmentSession);
            $assessmentSession->setUserAccount($this);
        }

        return $this;
    }

    public function removeAssessmentSession(AssessmentSession $assessmentSession): static
    {
        if ($this->assessmentSessions->removeElement($assessmentSession)) {
            // set the owning side to null (unless already changed)
            if ($assessmentSession->getUserAccount() === $this) {
                $assessmentSession->setUserAccount(null);
            }
        }

        return $this;
    }
}