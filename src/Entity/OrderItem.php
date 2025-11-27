<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    // Côté propriétaire de la relation vers Order
    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Order $order = null;
    // Lien optionnel vers Product (pour retrouver la fiche)
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Product $product = null;
    // Snapshot du nom du produit au moment de la commande
    #[ORM\Column(type: 'string', length: 255)]
    private string $productName = '';
    // Prix unitaire (centimes)
    #[ORM\Column(type: 'integer')]
    private int $unitPrice = 0;
    // Quantité commandée (>=1)
    #[ORM\Column(type: 'integer')]
    private int $quantity = 1;
    // --- Getters / Setters ---
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getOrder(): ?Order
    {
        return $this->order;
    }
    public function setOrder(?Order $order): self
    {
        $this->order = $order;
        return $this;
    }
    public function getProduct(): ?Product
    {
        return $this->product;
    }
    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }
    public function getProductName(): string
    {
        return $this->productName;
    }
    public function setProductName(string $productName): self
    {
        $this->productName = $productName;
        return $this;
    }
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }
    public function setUnitPrice(int $unitPrice): self
    {
        $this->unitPrice = max(0, $unitPrice);
        return $this;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function setQuantity(int $quantity): self
    {
        $this->quantity = max(1, $quantity);
        return $this;
    }
    // Total de la ligne en centimes
    public function getSubtotal(): int
    {
        return $this->quantity * $this->unitPrice;
    }
}
