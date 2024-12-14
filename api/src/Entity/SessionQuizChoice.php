<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionQuizChoiceRepository;
use Doctrine\ORM\Mapping as ORM;
// use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SessionQuizChoiceRepository::class)]
// #[UniqueEntity(['assessmentsession', 'choice'])]
#[ORM\UniqueConstraint(
    name: 'unique_session_choice', 
    columns: ['assessmentsession_id', 'choice_id']
)]
#[ApiResource]
class SessionQuizChoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sessionQuizChoices')]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
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
