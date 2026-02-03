<?php

namespace App\Controller;


use App\Form\AdminCategoryControllerType;
use App\Form\AdminCategoryType;
use App\Repository\AdminCategoryControllerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/category')]
final class AdminCategoryController extends AbstractController
{
    #[Route(name: 'app_admin_category_index', methods: ['GET'])]
    public function index(AdminCategoryControllerRepository $adminCategoryControllerRepository): Response
    {
        return $this->render('admin_category/index.html.twig', [
            'admin_category_controllers' => $adminCategoryControllerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adminCategoryController = new self();
        $form = $this->createForm(AdminCategoryType::class, $adminCategoryController);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adminCategoryController);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_category/new.html.twig', [
            'admin_category_controller' => $adminCategoryController,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_category_show', methods: ['GET'])]
    public function show(self $adminCategoryController): Response
    {
        return $this->render('admin_category/show.html.twig', [
            'admin_category_controller' => $adminCategoryController,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, self $adminCategoryController, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminCategoryType::class, $adminCategoryController);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_category/edit.html.twig', [
            'admin_category_controller' => $adminCategoryController,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_category_delete', methods: ['POST'])]
    public function delete(Request $request, self $adminCategoryController, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adminCategoryController->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($adminCategoryController);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
