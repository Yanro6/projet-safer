<?php

namespace App\Entity;

use App\Repository\PorteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PorteurRepository::class)
 */
class Porteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    # Biens mis en favori par le Porteur (de projet)
    /**
     * @ORM\ManyToMany(targetEntity=Bien::class, inversedBy="porteurs")
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
        }

        return $this;
    }

    public function removeBien(Bien $bien): self
    {
        $this->biens->removeElement($bien);

        return $this;
    }
}
