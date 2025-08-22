<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController


{
    #[Route('/Profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('home/profile.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }


}
