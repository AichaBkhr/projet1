<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
#[UniqueEntity('reference')]
#[UniqueEntity('Cle_2')]
#[UniqueEntity('QrCode')]
class Commandes
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; 

    #[ORM\Column(length: 20, unique : true)]
    private ?string $reference = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $date_de_creation = null;

    #[ORM\Column(length: 255, unique : true)]
    private ?string $Cle_2 = null; 

    #[ORM\Column(length: 255, unique : true)]
    private ?string $QrCode = null; 

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateurs $utilisateur = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: DetailsCommandes::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $detailsCommandes;

    public function __construct()
    {
        $this->detailsCommandes = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();

    }

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

    /**
     * @return Collection<int, DetailsCommandes>
     */
    public function getDetailsCommandes(): Collection
    {
        return $this->detailsCommandes;
    }

    public function addDetailsCommandes(DetailsCommandes $detailsCommande): static
    {
        if (!$this->detailsCommandes->contains($detailsCommande)) {
            $this->detailsCommandes->add($detailsCommande);
            $detailsCommande->setCommandes($this);
        }

        return $this;
    }

    public function removeDetailsCommandes(DetailsCommandes $detailsCommande): static
    {
        if ($this->detailsCommandes->removeElement($detailsCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailsCommande->getCommandes() === $this) {
                $detailsCommande->setCommandes(null);
            }
        }

        return $this;
    } 
}
