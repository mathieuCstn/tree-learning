<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
#[ApiResource]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $repositoryLink = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $moduleOrder = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $duration = null;

    /**
     * @var Collection<int, Course>
     */
    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'modules')]
    private Collection $courses;

    /**
     * @var Collection<int, Chapter>
     */
    #[ORM\OneToMany(targetEntity: Chapter::class, mappedBy: 'module')]
    private Collection $chapters;


    #[ORM\Column(nullable: true)]
    private ?bool $is_updated = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, UserModulePlanning>
     */
    #[ORM\OneToMany(targetEntity: UserModulePlanning::class, mappedBy: 'module')]
    private Collection $userModulePlannings;

    /**
     * @var Collection<int, Raiting>
     */
    #[ORM\OneToMany(targetEntity: Raiting::class, mappedBy: 'module')]
    private Collection $raitings;


    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->chapters = new ArrayCollection();
        $this->userModulePlannings = new ArrayCollection();
        $this->raitings = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getRepositoryLink(): ?string
    {
        return $this->repositoryLink;
    }

    public function setRepositoryLink(?string $repositoryLink): static
    {
        $this->repositoryLink = $repositoryLink;

        return $this;
    }

    public function getModuleOrder(): ?int
    {
        return $this->moduleOrder;
    }

    public function setModuleOrder(?int $moduleOrder): static
    {
        $this->moduleOrder = $moduleOrder;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->addModule($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            $course->removeModule($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Chapter>
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): static
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters->add($chapter);
            $chapter->setModule($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): static
    {
        if ($this->chapters->removeElement($chapter)) {
            // set the owning side to null (unless already changed)
            if ($chapter->getModule() === $this) {
                $chapter->setModule(null);
            }
        }

        return $this;
    }

    public function isUpdated(): ?bool
    {
        return $this->is_updated;
    }

    public function setUpdated(?bool $is_updated): static
    {
        $this->is_updated = $is_updated;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

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
            $userModulePlanning->setModule($this);
        }

        return $this;
    }

    public function removeUserModulePlanning(UserModulePlanning $userModulePlanning): static
    {
        if ($this->userModulePlannings->removeElement($userModulePlanning)) {
            // set the owning side to null (unless already changed)
            if ($userModulePlanning->getModule() === $this) {
                $userModulePlanning->setModule(null);
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
            $raiting->setModule($this);
        }

        return $this;
    }

    public function removeRaiting(Raiting $raiting): static
    {
        if ($this->raitings->removeElement($raiting)) {
            // set the owning side to null (unless already changed)
            if ($raiting->getModule() === $this) {
                $raiting->setModule(null);
            }
        }

        return $this;
    }


}
