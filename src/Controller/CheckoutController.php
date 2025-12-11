<?php
// 🎯 Objectif : 1) Lire le panier (session) 2) Afficher form OrderType
// 3) Si valide, remplir total/status, créer OrderItem(s) depuis le panier, puis flush.
namespace App\Controller;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\OrderType;
use App\Repository\ProductRepository;
use App\Service\Cart; // service session (RequestStack)
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class CheckoutController extends AbstractController
{
#[Route('/checkout', name: 'checkout')]
public function checkout(
Request $request,           // pour gérer la soumission du formulaire
Cart $cart,                 // notre service panier (session)
ProductRepository $repo,    // pour relire les produits (prix, nom)
EntityManagerInterface $em,   // pour persister Order/OrderItem

) {
// 1) Construire le récap panier depuis la session
$lines = [];
 $total = 0;
 
foreach ($cart->all() as $id => $qty) {
       $p = $repo->find($id); 

if (!$p) { continue; } // si un produit a été supprimé en BDD
$lines[] = ['p' => $p, 'qty' => $qty, 'unit' => $p->getPrix()];
$total += $qty * $p->getPrix();

}

// 2) Si panier vide, on redirige vers la page panier
if ($total <= 0) {
$this->addFlash('warning', 'Votre panier est vide.');
return $this->redirectToRoute('cart_show');
}
// 3) Créer un Order et lier le formulaire OrderType dessus
$order = new Order();


// 4) À la soumission valide :

// Fixer les champs techniques côté serveur (sécurité)
$order
->setStatus('paid')           // simulation : paiement OK
->setTotal($total);           // total en centimes (depuis le panier)
// 5) Créer les lignes OrderItem (snapshot nom/prix/qté)
foreach ($lines as $l) {
$item = (new OrderItem())
->setOrder($order)
->setProduct($l['p'])                // lien optionnel au Product
->setProductName($l['p']->getTitre()) // snapshot du nom
->setUnitPrice($l['unit'])           // snapshot du PU en centimes
->setQuantity($l['qty']);            // quantité commandée
$em->persist($item);
     // Mise à jour du stock
$p->setStock($p->getStock() - $l['qty']);
}
// 6) Sauvegarder la commande et vider le panier session
$em->persist($order);
$em->flush();
$cart->clear();
$this->addFlash('success', 'Commande créée, merci !');

// 7) Afficher la page checkout avec le récap + form
return $this->render('home/profile.html.twig', [

'lines' => $lines,
'total' => $total
]);
}
}
