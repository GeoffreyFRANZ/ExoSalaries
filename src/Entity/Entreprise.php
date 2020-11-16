<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $raisonSocial;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Salarie::class, mappedBy="entreprise")
     */
    private $salaries;

    public function __construct()
    {
        $this->salaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->raisonSocial;
    }

    public function setRaisonSocial(string $raisonSocial): self
    {
        $this->raisonSocial = $raisonSocial;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Salarie[]
     */
    public function getSalaries(): Collection
    {
        return $this->salaries;
    }

    public function addSalarie(Salarie $salarie): self
    {
        if (!$this->salaries->contains($salarie)) {
            $this->salaries[] = $salarie;
            $salarie->setEntreprise($this);
        }

        return $this;
    }

    public function removeSalarie(Salarie $salarie): self
    {
        if ($this->salaries->contains($salarie)) {
            $this->salaries->removeElement($salarie);
            // set the owning side to null (unless already changed)
            if ($salarie->getEntreprise() === $this) {
                $salarie->setEntreprise(null);
            }
        }

        return $this;
    } 
   
}
