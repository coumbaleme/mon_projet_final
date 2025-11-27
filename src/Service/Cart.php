<?php
// src/Service/Cart.php
// 👉 Ce service lit/écrit le panier dans la session.
// 👉 On l'appelle depuis les contrôleurs pour ajouter, mettre à jour, etc.
namespace App\Service;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Product;
class Cart
{
public function __construct(private RequestStack $rs) {

}



private function session() { 
    
    return $this->rs->getSession(); 

}



/** Retourne tout le panier (id => qty) */
public function all(): array {
return $this->session()->get('cart', []);
}




/** Ajoute un produit (ou incrémente sa quantité) */
public function add(Product $p, int $qty = 1): void {
$cart = $this->all();
$id = $p->getId();
$cart[$id] = ($cart[$id] ?? 0) + max(1, $qty); // min 1
$this->session()->set('cart', $cart);
}



/** Fixe une quantité précise (0 = supprime) */
public function set(int $productId, int $qty): void {
$cart = $this->all();
if ($qty > 0) { $cart[$productId] = $qty; }
else { unset($cart[$productId]); }
$this->session()->set('cart', $cart);
}


/** Supprime un produit du panier */
public function remove(int $productId): void {
$cart = $this->all();
unset($cart[$productId]);
$this->session()->set('cart', $cart);
}



/** Vide entièrement le panier */
public function clear(): void {
$this->session()->remove('cart');
}
}
