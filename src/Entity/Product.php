<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $Category = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?CategoryMetier $metier = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?CategoryProjet $projet = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?CategoryTraveaux $traveaux = null;




    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getMetier(): ?CategoryMetier
    {
        return $this->metier;
    }

    public function setMetier(?CategoryMetier $metier): static
    {
        $this->metier = $metier;

        return $this;
    }

    public function getProjet(): ?CategoryProjet
    {
        return $this->projet;
    }

    public function setProjet(?CategoryProjet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getTraveaux(): ?CategoryTraveaux
    {
        return $this->traveaux;
    }

    public function setTraveaux(?CategoryTraveaux $traveaux): static
    {
        $this->traveaux = $traveaux;

        return $this;
    }

     #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private ?int $stock = 0;

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

 public function decreaseStock(int $quantity): self
    {
        $this->stock -= $quantity;
        if ($this->stock < 0) {
            $this->stock = 0;
        }
        return $this;
    }



}


