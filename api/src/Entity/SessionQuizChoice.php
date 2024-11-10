<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionQuizChoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionQuizChoiceRepository::class)]
#[ApiResource]
class SessionQuizChoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $score = null;

    #[ORM\ManyToOne(inversedBy: 'sessionQuizChoices')]
    private ?AssessmentSession $assessmentsession = null;

    #[ORM\ManyToOne(inversedBy: 'sessionQuizChoices')]
    private ?Choice $choice = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getAssessmentsession(): ?AssessmentSession
    {
        return $this->assessmentsession;
    }

    public function setAssessmentsession(?AssessmentSession $assessmentsession): static
    {
        $this->assessmentsession = $assessmentsession;

        return $this;
    }

    public function getChoice(): ?Choice
    {
        return $this->choice;
    }

    public function setChoice(?Choice $choice): static
    {
        $this->choice = $choice;

        return $this;
    }

}
