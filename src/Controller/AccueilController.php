<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function accueil(): Response
    {
        return $this->render('home/accueil.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    
     #[Route('/Produits', name: 'app_produits')]
    public function Produits(): Response
    {
        return $this->render('home/produits.html.twig', [
            'controller_name' => 'produitsController',
        ]);
    }

    
    

    
    #[Route('/Panier', name: 'app_panier')]
    public function panier(): Response
    {
        // Exemples de projets à afficher : source base de données ou fichiers
        $projets = [
            ['nom' => 'Gare T3', 'image' => 'images/projets/gare-t3.jpg'],
            ['nom' => 'Lotissement Île-de-France', 'image' => 'images/projets/lotissement-idf.jpg'],
            // ...
        ];

        return $this->render('home/Panier.html.twig', [
            'projets' => $projets,
        ]);
    }

    
    #[Route('/home', name: 'app_homepage')]
    public function home(): Response
    {
        $cards = [
            ['number' => '01', 'title' => 'Architecture Design', 'description' => 'Conceptualisation et plans sur mesure.', 'route' => 'architecture'],
            ['number' => '02', 'title' => 'New Buildings', 'description' => 'Construction neuve résidentielle et professionnelle.', 'route' => 'buildings'],
            ['number' => '03', 'title' => 'Full Project', 'description' => 'Gestion complète de A à Z.', 'route' => 'full_project'],
            ['number' => '04', 'title' => 'Renovation', 'description' => 'Rénovation et remise à neuf.', 'route' => 'renovation'],
        ];

        return $this->render('home/home.html.twig', [
            'cards' => $cards,
        ]);
    }
}




