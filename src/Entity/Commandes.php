<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_de_creation = null;

    #[ORM\Column(length: 255, unique : true)]
    private ?string $Cle_2 = null;

    #[ORM\Column(length: 255, unique : true)]
    private ?string $QrCode = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Utilisateurs $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDateDeCreation(): ?\DateTimeImmutable
    {
        return $this->date_de_creation;
    }

    public function setDateDeCreation(\DateTimeImmutable $date_de_creation): static
    {
        $this->date_de_creation = $date_de_creation;

        return $this;
    }

    public function getCle2(): ?string
    {
        return $this->Cle_2;
    }

    public function setCle2(string $Cle_2): static
    {
        $this->Cle_2 = $Cle_2;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->QrCode;
    }

    public function setQrCode(string $QrCode): static
    {
        $this->QrCode = $QrCode;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateurs
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateurs $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
