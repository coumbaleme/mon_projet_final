<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DesboardController extends AbstractController
{
    #[Route('/desboard', name: 'app_desboard')]
    public function index(): Response
    {
        return $this->render('desboard/index.html.twig', [
            'controller_name' => 'DesboardController',
        ]);
    }
}
