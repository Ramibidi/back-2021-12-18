<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manager;
  

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projets")
     */
    private $collaborateur;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     * @ORM\JoinTable(name="user_managerProx")
     */
    private $managerProx;

    /**
     * @ORM\Column(type="boolean")
     */
    private $surSite;

    public function __construct()
    {
        $this->collaborateur = new ArrayCollection();
        $this->managerProx = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getCollaborateur(): Collection
    {
        return $this->collaborateur;
    }

    public function addCollaborateur(User $collaborateur): self
    {
        if (!$this->collaborateur->contains($collaborateur)) {
            $this->collaborateur[] = $collaborateur;
        }

        return $this;
    }

    public function removeCollaborateur(User $collaborateur): self
    {
        $this->collaborateur->removeElement($collaborateur);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getManagerProx(): Collection
    {
        return $this->managerProx;
    }

    public function addManagerProx(User $managerProx): self
    {
        if (!$this->managerProx->contains($managerProx)) {
            $this->managerProx[] = $managerProx;
        }

        return $this;
    }

    public function removeManagerProx(User $managerProx): self
    {
        $this->managerProx->removeElement($managerProx);

        return $this;
    }

    public function getSurSite(): ?bool
    {
        return $this->surSite;
    }

    public function setSurSite(bool $surSite): self
    {
        $this->surSite = $surSite;

        return $this;
    }
}
