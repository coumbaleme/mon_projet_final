<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function accueil(ProductRepository $repoProduct): Response
    {

        $produit = $repoProduct->findAll();




        //    dd($produit);






        return $this->render('home/accueil.html.twig', [
            'product' => $produit,

        ]);
    }

    #[Route('/Produits', name: 'app_produits')]
    public function Produits(): Response
    {
        return $this->render('produits/produits.html.twig', [
            'controller_name' => 'produitsController',
        ]);
    }





    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request): Response
    {
        $panier = $request->getSession()->get('panier', []);

        return $this->render('home/panier.html.twig', [
            'panier' => $panier,
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


    #[Route('/Apropos', name: 'app_apropos')]
    public function apropos(): Response
    {
     

        return $this->render('home/apropos.html.twig', [
          
        ]);
    }
    
}
