<?php

namespace App\Controller;

use App\Entity\CategoryUser;
use App\Form\CategoryUserType;
use App\Repository\CategoryUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('categoryUser')]
final class CategoryUserController extends AbstractController
{
    #[Route(name: 'app_category_user_index', methods: ['GET'])]
    public function index(CategoryUserRepository $categoryUserRepository): Response
    {
        return $this->render('category_user/index.html.twig', [
            'category_users' => $categoryUserRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoryUser = new CategoryUser();
        $form = $this->createForm(CategoryUserType::class, $categoryUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categoryUser);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_user/new.html.twig', [
            'category_user' => $categoryUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_user_show', methods: ['GET'])]
    public function show(CategoryUser $categoryUser): Response
    {
        return $this->render('category_user/show.html.twig', [
            'category_user' => $categoryUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryUser $categoryUser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryUserType::class, $categoryUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_category_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_user/edit.html.twig', [
            'category_user' => $categoryUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_user_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryUser $categoryUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryUser->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categoryUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
