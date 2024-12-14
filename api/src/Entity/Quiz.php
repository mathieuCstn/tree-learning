<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['quiz:read']
    ],
    denormalizationContext: [
        'groups' => ['quiz:write']
    ]
)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quiz:read', 'user:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['quiz:read', 'user:read'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['quiz:read', 'user:read'])]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, AssessmentSession>
     */
    #[ORM\OneToMany(targetEntity: AssessmentSession::class, mappedBy: 'quiz')]
    #[Groups(['quiz:read'])]
    private Collection $assementsession;

    /**
     * @var Collection<int, Question>
     */
    #[ORM\ManyToMany(targetEntity: Question::class, inversedBy: 'quizzes')]
    #[Groups(['quiz:read'])]
    private Collection $questions;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'quizzes')]
    private Collection $skills;

    public function __construct()
    {
        $this->assementsession = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, AssessmentSession>
     */
    public function getAssementsession(): Collection
    {
        return $this->assementsession;
    }

    public function addAssementsession(AssessmentSession $assementsession): static
    {
        if (!$this->assementsession->contains($assementsession)) {
            $this->assementsession->add($assementsession);
            $assementsession->setQuiz($this);
        }

        return $this;
    }

    public function removeAssementsession(AssessmentSession $assementsession): static
    {
        if ($this->assementsession->removeElement($assementsession)) {
            // set the owning side to null (unless already changed)
            if ($assementsession->getQuiz() === $this) {
                $assementsession->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        $this->questions->removeElement($question);

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
}
