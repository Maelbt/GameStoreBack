<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
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
    private $picture;

    public function __construct()
    {
        $this->picture = new ArrayCollection();
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

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setGame($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getGame() === $this) {
                $picture->setGame(null);
            }
        }

        return $this;
    }
}
