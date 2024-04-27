<?php

namespace App\Entity;

use App\Repository\DetailsCommandesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsCommandesRepository::class)]
class DetailsCommandes
{    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; 

    #[ORM\Column]
    private ?int $quantité = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\ManyToOne(targetEntity: Commandes::class, inversedBy: 'detailsCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commandes $commande = null;

    #[ORM\ManyToOne(targetEntity: Offres::class, inversedBy: 'detailsCommandes')]
    private ?Offres $offre = null;

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
        return $this->commande;
    }

    public function setCommandes(?Commandes $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getOffres(): ?Offres
    {
        return $this->offre;
    }

    public function setOffres(?Offres $offre): static
    {
        $this->offre = $offre;

        return $this;
    }
}
