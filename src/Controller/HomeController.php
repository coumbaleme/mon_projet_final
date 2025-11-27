<?php
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function panier(SessionInterface $session): Response
    {
        // Exemple de panier (si la session est vide)
        $panier = $session->get('panier', [
            ['nom' => 'Produit 1', 'prix' => 10, 'quantite' => 2],
            ['nom' => 'Produit 2', 'prix' => 5, 'quantite' => 1],
        ]);

        $total = 0;
        foreach ($panier as $item) {
            $total += $item['prix'] * $item['quantite'];
        }

        return $this->render('home/panier.html.twig', [
            'panier' => $panier,
            'total' => $total,
        ]);
    }
}
