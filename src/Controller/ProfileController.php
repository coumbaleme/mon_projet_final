<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\OrderRepository;

final class ProfileController extends AbstractController


{#[Route('/Profile', name: 'app_profile')]
public function index(OrderRepository $orderRepository): Response
{
    $user = $this->getUser();

    if (!$user) {
        throw $this->createAccessDeniedException("Vous devez être connecté.");
    }

    // Récupérer les commandes du user
    $commandes = $orderRepository->findBy(['user' => $user]);

    return $this->render('home/profile.html.twig', [
        'commandes' => $commandes,
    ]);
}



}
