<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $terrainAgricole;

    /**
     * @ORM\Column(type="boolean")
     */
    private $prairie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bois;

    /**
     * @ORM\Column(type="boolean")
     */
    private $batiment;

    /**
     * @ORM\Column(type="boolean")
     */
    private $exploitations;

    /**
     * @ORM\OneToMany(targetEntity=Bien::class, mappedBy="categorie")
     */
    private $biens;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isTerrainAgricole(): ?bool
    {
        return $this->terrainAgricole;
    }

    public function setTerrainAgricole(bool $terrainAgricole): self
    {
        $this->terrainAgricole = $terrainAgricole;

        return $this;
    }

    public function isPrairie(): ?bool
    {
        return $this->prairie;
    }

    public function setPrairie(bool $prairie): self
    {
        $this->prairie = $prairie;

        return $this;
    }

    public function isBois(): ?bool
    {
        return $this->bois;
    }

    public function setBois(bool $bois): self
    {
        $this->bois = $bois;

        return $this;
    }

    public function isBatiment(): ?bool
    {
        return $this->batiment;
    }

    public function setBatiment(bool $batiment): self
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function isExploitations(): ?bool
    {
        return $this->exploitations;
    }

    public function setExploitations(bool $exploitations): self
    {
        $this->exploitations = $exploitations;

        return $this;
    }

    /**
     * @return Collection<int, Bien>
     */
    public function getBiens(): Collection
    {
        return $this->biens;
    }

    public function addBien(Bien $bien): self
    {
        if (!$this->biens->contains($bien)) {
            $this->biens[] = $bien;
            $bien->setCategorie($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): self
    {
        if ($this->biens->removeElement($bien)) {
            // set the owning side to null (unless already changed)
            if ($bien->getCategorie() === $this) {
                $bien->setCategorie(null);
            }
        }

        return $this;
    }
}
