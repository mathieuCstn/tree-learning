<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\AssessmentSessionStatus;
use App\Repository\AssessmentSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AssessmentSessionRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['assessment_session:read']
    ],
    denormalizationContext: [
        'groups' => ['assessment_session:write']
    ]
)]
class AssessmentSession
{
    //todo: ajouter un status pending, completed, validated
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $completed_at = null;

    #[ORM\ManyToOne(inversedBy: 'assessmentSessions')]
    #[Groups(['assessment_session:read','assessment_session:write'])]
    private ?User $userAccount = null;

    /**
     * @var Collection<int, SessionQuizChoice>
     */
    #[ORM\OneToMany(targetEntity: SessionQuizChoice::class, mappedBy: 'assessmentsession')]
    #[Groups(['assessment_session:read','assessment_session:write', 'user:read'])]
    private Collection $sessionQuizChoices;

    #[ORM\ManyToOne(inversedBy: 'assementsession')]
    #[Groups(['assessment_session:read','assessment_session:write', 'user:read'])]
    private ?Quiz $quiz = null;

    #[ORM\Column(enumType: AssessmentSessionStatus::class)]
    #[Groups(['assessment_session:read','assessment_session:write', 'user:read'])]
    private ?AssessmentSessionStatus $status = AssessmentSessionStatus::PENDING;

    public function __construct()
    {
        $this->sessionQuizChoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completed_at;
    }

    public function setCompletedAt(?\DateTimeImmutable $completed_at): static
    {
        $this->completed_at = $completed_at;

        return $this;
    }

    public function getUserAccount(): ?User
    {
        return $this->userAccount;
    }

    public function setUserAccount(?User $userAccount): static
    {
        $this->userAccount = $userAccount;

        return $this;
    }

    /**
     * @return Collection<int, SessionQuizChoice>
     */
    public function getSessionQuizChoices(): Collection
    {
        return $this->sessionQuizChoices;
    }

    public function addSessionQuizChoice(SessionQuizChoice $sessionQuizChoice): static
    {
        if (!$this->sessionQuizChoices->contains($sessionQuizChoice)) {
            $this->sessionQuizChoices->add($sessionQuizChoice);
            $sessionQuizChoice->setAssessmentsession($this);
        }

        return $this;
    }

    public function removeSessionQuizChoice(SessionQuizChoice $sessionQuizChoice): static
    {
        if ($this->sessionQuizChoices->removeElement($sessionQuizChoice)) {
            // set the owning side to null (unless already changed)
            if ($sessionQuizChoice->getAssessmentsession() === $this) {
                $sessionQuizChoice->setAssessmentsession(null);
            }
        }

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getStatus(): ?AssessmentSessionStatus
    {
        return $this->status;
    }

    public function setStatus(AssessmentSessionStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

}
