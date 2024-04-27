<?php

namespace App\Entity;

use App\Repository\OffresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OffresRepository::class)] 
class Offres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique : true)]
    #[Assert\NotBlank(message: 'Le type de l\'offre ne peut pas être vide !')]
    private ?string $type = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\PositiveOrZero(message:'Le prix ne peut pas être négatif')]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message:'La capacité ne peut pas être négative')]
    private ?int $capacite = null;


    #[ORM\OneToMany(mappedBy: 'offres', targetEntity: DetailsCommandes::class)]
    private Collection $detailsCommandes;

    #[ORM\Column]
    private ?int $nombreDeVentes = 0;


    public function __construct()
    {
        $this->detailsCommandes = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    

    /**
     * @return Collection<int, DetailsCommandes>
     */
    public function getDetailsCommandes(): Collection
    {
        return $this->detailsCommandes;
    }

    public function addDetailsCommande(DetailsCommandes $detailsCommande): static
    {
        if (!$this->detailsCommandes->contains($detailsCommande)) {
            $this->detailsCommandes->add($detailsCommande);
            $detailsCommande->setOffres($this);
        }

        return $this;
    }

    public function removeDetailsCommande(DetailsCommandes $detailsCommande): static
    {
        if ($this->detailsCommandes->removeElement($detailsCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailsCommande->getOffres() === $this) {
                $detailsCommande->setOffres(null);
            }
        }

        return $this;
    }

    public function getNombreDeVentes(): ?int
    {
        return $this->nombreDeVentes;
    }

    public function setNombreDeVentes(?int $nombreDeVentes): static
    {
        $this->nombreDeVentes = $nombreDeVentes;

        return $this;
    }

}
