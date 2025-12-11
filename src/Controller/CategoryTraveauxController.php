<?php

namespace App\Controller;

use App\Entity\CategoryTraveaux;
use App\Form\CategoryTraveaux1Type;
use App\Repository\CategoryTraveauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorytraveaux')]
final class CategoryTraveauxController extends AbstractController
{
    #[Route(name: 'app_category_traveaux_index', methods: ['GET'])]
    public function index(CategoryTraveauxRepository $categoryTraveauxRepository): Response
    {
        return $this->render('category_traveaux/index.html.twig', [
            'category_traveauxes' => $categoryTraveauxRepository->findAll(),
        ]);

  # $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
    }

    #[Route('/new', name: 'app_category_traveaux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoryTraveaux = new CategoryTraveaux();
        $form = $this->createForm(CategoryTraveaux1Type::class, $categoryTraveaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFilename = $this->handleImageUpload($form, 'images_directory');
            if ($newFilename) {
                $categoryTraveaux->setImage($newFilename);
            }

            $entityManager->persist($categoryTraveaux);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_traveaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_traveaux/new.html.twig', [
            'category_traveaux' => $categoryTraveaux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_traveaux_show', methods: ['GET'])]
    public function show(CategoryTraveaux $categoryTraveaux): Response
    {
        return $this->render('category_traveaux/show.html.twig', [
            'category_traveaux' => $categoryTraveaux,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_traveaux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryTraveaux $categoryTraveaux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryTraveaux1Type::class, $categoryTraveaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFilename = $this->handleImageUpload($form, 'images_directory');
            if ($newFilename) {
                $categoryTraveaux->setImage($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_category_traveaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_traveaux/edit.html.twig', [
            'category_traveaux' => $categoryTraveaux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_traveaux_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryTraveaux $categoryTraveaux, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryTraveaux->getId(), $request->getPayload()->getString('_token'))) {
            // Supprimer l'image associée
            $imagePath = $this->getParameter('images_directory') . '/' . $categoryTraveaux->getImage();
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $entityManager->remove($categoryTraveaux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_traveaux_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Méthode privée pour gérer l'upload d'image
     */
    private function handleImageUpload($form, string $uploadDirParam): ?string
    {
        $imageFile = $form->get('image')->getData();

        if ($imageFile) {
            $extension = $imageFile->guessExtension();
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($extension, $allowedExtensions)) {
                $this->addFlash('error', 'Format de fichier non autorisé.');
                return null;
            }

            $newFilename = uniqid() . '.' . $extension;

            try {
                $imageFile->move(
                    $this->getParameter($uploadDirParam),
                    $newFilename
                );
                return $newFilename;
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
            }
        }

        return null;
    }
}
