<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\OrderRepository;

final class ProfileController extends AbstractController


{
    #[Route('/Profile', name: 'app_profile')]
    public function index(OrderRepository $order): Response
    {
        dd( $this->getUser());
        
     $commandes = $order->findBy(['user' => $this->getUser()]);
        return $this->render('home/profile.html.twig', [
            'commandes' => $commandes,
        ]);
    }


}
