<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MouvieListRepository")
 */
class MouvieList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="yes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Mouvies")
     */
    private $mouvies;

    public function __construct()
    {
        $this->mouvies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Mouvies[]
     */
    public function getMouvies(): Collection
    {
        return $this->mouvies;
    }

    public function addMouvy(Mouvies $mouvy): self
    {
        if (!$this->mouvies->contains($mouvy)) {
            $this->mouvies[] = $mouvy;
        }

        return $this;
    }

    public function removeMouvy(Mouvies $mouvy): self
    {
        if ($this->mouvies->contains($mouvy)) {
            $this->mouvies->removeElement($mouvy);
        }

        return $this;
    }
}
