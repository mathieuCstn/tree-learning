<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ChoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChoiceRepository::class)]
#[ApiResource]
class Choice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $is_correct = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $feedback = null;

    #[ORM\ManyToOne(inversedBy: 'choices', cascade:["persist"])]
    private ?Question $question = null;

    /**
     * @var Collection<int, SessionQuizChoice>
     */
    #[ORM\OneToMany(targetEntity: SessionQuizChoice::class, mappedBy: 'choice')]
    private Collection $sessionQuizChoices;

    public function __construct()
    {
        $this->sessionQuizChoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getIsCorrect(): ?bool
    {
        return $this->is_correct;
    }

    public function setIsCorrect(bool $is_correct): static
    {
        $this->is_correct = $is_correct;

        return $this;
    }

    public function getFeedback(): ?string
    {
        return $this->feedback;
    }

    public function setFeedback(?string $feedback): static
    {
        $this->feedback = $feedback;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

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
            $sessionQuizChoice->setChoice($this);
        }

        return $this;
    }

    public function removeSessionQuizChoice(SessionQuizChoice $sessionQuizChoice): static
    {
        if ($this->sessionQuizChoices->removeElement($sessionQuizChoice)) {
            // set the owning side to null (unless already changed)
            if ($sessionQuizChoice->getChoice() === $this) {
                $sessionQuizChoice->setChoice(null);
            }
        }

        return $this;
    }

}
