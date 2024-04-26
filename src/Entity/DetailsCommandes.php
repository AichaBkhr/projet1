<?php

namespace App\Entity;

use App\Repository\DetailsCommandesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsCommandesRepository::class)]
class DetailsCommandes
{
    
    

    #[ORM\Column]
    private ?int $quantité = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Commandes::class,inversedBy: 'details_commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commandes $commandes = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Offres::class, inversedBy: 'detailsCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offres $offres = null;


    
    public function getQuantité(): ?int
    {
        return $this->quantité;
    }

    public function setQuantité(int $quantité): static
    {
        $this->quantité = $quantité;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCommandes(): ?Commandes
    {
        return $this->commandes;
    }

    public function setCommandes(?Commandes $commandes): static
    {
        $this->commandes = $commandes;

        return $this;
    }

    public function getOffres(): ?Offres
    {
        return $this->offres;
    }

    public function setOffres(?Offres $offres): static
    {
        $this->offres = $offres;

        return $this;
    }

    
}
