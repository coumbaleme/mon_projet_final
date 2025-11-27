<?php

namespace App\Controller;

use App\Entity\CategoryAdminController;
use App\Form\CategoryAdminControllerType;
use App\Repository\CategoryAdminControllerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category/admin/controller')]
final class CategoryAdminControllerController extends AbstractController
{
    #[Route(name: 'app_category_admin_controller_index', methods: ['GET'])]
    public function index(CategoryAdminControllerRepository $categoryAdminControllerRepository): Response
    {
        return $this->render('category_admin_controller/index.html.twig', [
            'category_admin_controllers' => $categoryAdminControllerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_admin_controller_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoryAdminController = new CategoryAdminController();
        $form = $this->createForm(CategoryAdminControllerType::class, $categoryAdminController);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categoryAdminController);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_admin_controller_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_admin_controller/new.html.twig', [
            'category_admin_controller' => $categoryAdminController,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_admin_controller_show', methods: ['GET'])]
    public function show(CategoryAdminController $categoryAdminController): Response
    {
        return $this->render('category_admin_controller/show.html.twig', [
            'category_admin_controller' => $categoryAdminController,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_admin_controller_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryAdminController $categoryAdminController, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryAdminControllerType::class, $categoryAdminController);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_category_admin_controller_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_admin_controller/edit.html.twig', [
            'category_admin_controller' => $categoryAdminController,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_admin_controller_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryAdminController $categoryAdminController, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryAdminController->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categoryAdminController);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_admin_controller_index', [], Response::HTTP_SEE_OTHER);
    }
}
