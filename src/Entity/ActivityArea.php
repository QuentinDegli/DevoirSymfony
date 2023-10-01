<?php

namespace App\Entity;

use App\Repository\ActivityAreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityAreaRepository::class)]
class ActivityArea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'activityArea', targetEntity: User::class)]
    private Collection $title;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->title = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getTitle(): Collection
    {
        return $this->title;
    }

    public function addTitle(User $title): static
    {
        if (!$this->title->contains($title)) {
            $this->title->add($title);
            $title->setActivityArea($this);
        }

        return $this;
    }

    public function removeTitle(User $title): static
    {
        if ($this->title->removeElement($title)) {
            // set the owning side to null (unless already changed)
            if ($title->getActivityArea() === $this) {
                $title->setActivityArea(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
