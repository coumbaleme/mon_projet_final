<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CommandeController extends AbstractController
{
    #[Route('/mes-commandes', name: 'mes_commandes')]
    #[IsGranted('ROLE_USER')]
    public function mesCommandes(OrderRepository $order): Response
    {
     $commandes = $order->findBy(['user' => $this->getUser()], ['createdAt' => 'DESC']);
        return $this->render('commande/liste.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/mes-commandes/{id}', name: 'commande_detail')]
    #[IsGranted('ROLE_USER')]
    public function detail(Order $commande): Response
    {
        if ($commande->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Accès refusé !");
        }

        return $this->render('commande/detail.html.twig', [
            'commande' => $commande,
        ]);
    }
}
