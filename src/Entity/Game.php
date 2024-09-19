<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    #[Groups(['game:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['game:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length:32)]
    private ?int $pegi = null;

    #[ORM\Column(length:180)]
    private ?array $genre = [];

    #[ORM\Column(length: 180)]
    private ?array $plateforme = [];

    #[ORM\Column(length:32)]
    private ?float $price = null;

    #[ORM\Column(length:32)]
    private ?int $promotion = null;

    #[ORM\Column(length:32)]
    private ?int $quantity = null;

    #[ORM\Column(length:32)]
    private ?string $releaseDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(targetEntity: Picture::class, mappedBy: 'game', orphanRemoval: true)]
    #[Groups(['game:read'])]
    #[MaxDepth(1)]
    private ?Picture $picture = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'game')]
    private Collection $commandes;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\ManyToMany(targetEntity: Panier::class, inversedBy: 'game')]
    private Collection $paniers;

    /**
     * @var Collection<int, Ventes>
     */
    #[ORM\ManyToMany(targetEntity: Ventes::class, mappedBy: 'game')]
    private Collection $ventes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->ventes = new ArrayCollection();
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPegi(): ?int
    {
        return $this->pegi;
    }

    public function setPegi(int $pegi): static
    {
        $this->pegi = $pegi;

        return $this;
    }

    public function getGenre(): ?array
    {
        $genre = $this->genre;

        return array_unique($genre);
    }

    public function setGenre(array $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPlateforme(): ?array
    {
        $plateforme = $this->plateforme;

        return array_unique($plateforme);
    }

    public function setPlateforme(array $plateforme): static
    {
        $this->plateforme = $plateforme;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPromotion(): ?int
    {
        return $this->promotion;
    }

    public function setPromotion(int $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

 
    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): self
    {
        if ($picture === null && $this->picture !== null) {
            $this->picture->setGame(null);
        }

        if ($picture !== null && $picture->getGame() !== $this) {
            $picture->setGame($this);
        }

        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addGame($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeGame($this);
        }

        return $this;
    }

   /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->addGame($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            $panier->removeGame($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ventes>
     */
    public function getVentes(): Collection
    {
        return $this->ventes;
    }

    public function addVente(Ventes $vente): static
    {
        if (!$this->ventes->contains($vente)) {
            $this->ventes->add($vente);
            $vente->addGame($this);
        }

        return $this;
    }

    public function removeVente(Ventes $vente): static
    {
        if ($this->ventes->removeElement($vente)) {
            $vente->removeGame($this);
        }

        return $this;
    }
}
