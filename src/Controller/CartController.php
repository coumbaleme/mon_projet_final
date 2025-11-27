<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    // 👉 Cette action ajoute un produit dans le panier stocké en session.
    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(
        int $id,                      // ID du produit passé dans l'URL
        Request $request,            // Pour récupérer la quantité envoyée en POST
        ProductRepository $repo,     // Pour aller chercher le produit en base
        Cart $cart      // Notre service Cart (gère la session)
    ) {
        // On récupère le produit par son ID
        $product = $repo->find($id);
        // Si aucun produit trouvé, on renvoie une erreur 404
        // 👉 createNotFoundException() génère une exception qui affiche une page "Not Found"
        if (!$product) {
            throw $this->createNotFoundException('Produit introuvable');
        }
        // On récupère la quantité envoyée dans le formulaire (par défaut 1)
        // max(1, ...) => pour s'assurer qu'on a au moins 1
        $qty = max(1, (int) $request->request->get('quantity', 1));
        // On ajoute le produit dans le panier via notre service Cart
        $cart->add($product, $qty);
        // On affiche un message flash pour informer l'utilisateur
        $this->addFlash('success', 'Produit ajouté au panier.');
        // On redirige vers la page du panier
        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart', name: 'cart_show', methods: ['GET'])]
    public function show(\App\Service\Cart $cart, ProductRepository $repo)
    {
        $lines = [];
        $total = 0;
        foreach ($cart->all() as $id => $qty) {
            $p = $repo->find($id);
            if (!$p) {
                continue;
            } // si le produit n'existe plus
            $lines[] = [
                'id' => $p->getId(),
                'titre' => $p->getTitre(),
                'unitPrice' => $p->getPrix(),     // en centimes (int)
                'quantity' => $qty,
                'lineTotal' => $qty * $p->getPrix()
            ];
            $total += $qty * $p->getPrix();
        }
        return $this->render('cart/index.html.twig', compact('lines', 'total'));
    }
    #[Route('/cart/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function update(int $id, Request $req, \App\Service\Cart $cart)
    {
        $qty = max(0, (int) $req->request->get('qty', 1)); // 0 => suppression
        $cart->set($id, $qty);
        return $this->redirectToRoute('cart_show');
    }
    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function remove(int $id, \App\Service\Cart $cart)
    {
        $cart->remove($id);
        return $this->redirectToRoute('cart_show');
    }
}
// 







//     #[Route('/cart', name: 'app_cart')]
//     public function index(Request $request): Response
//     {
//         $cart = $request->getSession()->get('cart', []);

//         // Calcul du total
//         $total = 0;
//         foreach ($cart as $item) {
//             $total += $item['prix'] * $item['quantity'];
//         }

//         return $this->render('cart/index.html.twig', [
//             'cart' => $cart,
//             'total' => $total,
//         ]);
//     }

//     #[Route('/panier/ajouter/{id}', name: 'app_cart_add')]
//     public function add($id, ProductRepository $productRepository, Request $request): Response
//     {
//         $product = $productRepository->find($id);
//         $session = $request->getSession();
//         $cart = $session->get('cart', []);

//         if (!$product) {
//             throw $this->createNotFoundException("Produit non trouvé");
//         }

//         if (isset($cart[$id])) {
//             $cart[$id]['quantity']++;
//         } else {
//             $cart[$id] = [
//                 'titre' => $product->getTitre(),
//                 'prix' => $product->getPrix(),
//                 'quantity' => 1,
//                 'image' => $product->getImage(),
//             ];
//         }

//         $session->set('cart', $cart);

//         return $this->redirectToRoute('app_cart');
//     }

//     #[Route('/panier/supprimer/{id}', name: 'app_cart_remove')]
//     public function remove($id, Request $request): Response
//     {
//         $session = $request->getSession();
//         $cart = $session->get('cart', []);

//         if (isset($cart[$id])) {
//             unset($cart[$id]);
//         }

//         $session->set('cart', $cart);
//         return $this->redirectToRoute('app_cart');
//     }

//     #[Route('/panier/vider', name: 'app_cart_clear')]
//     public function clear(Request $request): Response
//     {
//         $session = $request->getSession();
//         $session->remove('cart');

//         return $this->redirectToRoute('app_cart');
//     }
// }// src/Controller/CartController.php
