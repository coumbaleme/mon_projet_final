<?php

namespace App\Entity;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type: 'integer')]
private ?int $id = null;
// Email saisi dans le form
#[ORM\Column(type: 'string', length: 180, nullable: true)]
private ?string $email = null;
// Adresse de livraison saisie dans le form (optionnelle)
#[ORM\Column(type: 'text', nullable: true)]
private ?string $shippingAddress = null;
// Total en centimes (int)
#[ORM\Column(type: 'integer')]
private int $total = 0;
// Exemple: 'paid', 'pending', 'canceled'...
#[ORM\Column(type: 'string', length: 32)]
private string $status = 'pending';
#[ORM\Column(type: 'datetime_immutable')]
private \DateTimeImmutable $createdAt;
// Lignes de commande
#[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class, cascade: ['persist'], orphanRemoval: true)]
private Collection $items;

#[ORM\ManyToOne(inversedBy: 'commande')]
private ?User $user = null;
public function __construct()
{
$this->createdAt = new \DateTimeImmutable();
$this->items = new ArrayCollection();
}
// --- Getters / Setters ---
public function getId(): ?int { return $this->id; }
public function getEmail(): ?string { return $this->email; }
public function setEmail(?string $email): self { $this->email = $email; return $this; }
public function getShippingAddress(): ?string { return $this->shippingAddress; }
public function setShippingAddress(?string $shippingAddress): self { $this->shippingAddress = $shippingAddress; return $this; }
public function getTotal(): int { return $this->total; }
public function setTotal(int $total): self { $this->total = max(0, $total); return $this; }
public function getStatus(): string { return $this->status; }
public function setStatus(string $status): self { $this->status = $status; return $this; }
public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
public function setCreatedAt(\DateTimeImmutable $createdAt): self { $this->createdAt = $createdAt; return $this; }
/** @return Collection */
public function getItems(): Collection { return $this->items; }
public function addItem(OrderItem $item): self
{
if (!$this->items->contains($item)) {
$this->items->add($item);
$item->setOrder($this);
}
return $this;
}
public function removeItem(OrderItem $item): self
{
if ($this->items->removeElement($item)) {
if ($item->getOrder() === $this) {
$item->setOrder(null);
}
}
return $this;
}
// Petit helper si tu veux recalculer le total depuis les lignes
public function recomputeTotalFromItems(): self
{
$sum = 0;
foreach ($this->items as $i) {
$sum += $i->getSubtotal();
}
$this->total = $sum;
return $this;
}

public function getUser(): ?User
{
    return $this->user;
}

public function setUser(?User $user): static
{
    $this->user = $user;

    return $this;
}
}