<?php

namespace App\Controller;

use App\Entity\CategoryProjet;
use App\Form\CategoryProjetType;
use App\Repository\CategoryProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('categoryprojet')]
final class CategoryProjetController extends AbstractController
{
    #[Route(name: 'app_category_projet_index', methods: ['GET'])]
    public function index(CategoryProjetRepository $categoryProjetRepository): Response
    {
        return $this->render('category_projet/index.html.twig', [
            'category_projets' => $categoryProjetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoryProjet = new CategoryProjet();
        $form = $this->createForm(CategoryProjetType::class, $categoryProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

               $imageFile = $form->get('image')->getData();
        
            // dd($imageFile);
            if ($imageFile) {
                // nous creons un variable $newFilename qui contiendra le nom du fichier de l'image
                //uniqid() → fonction PHP qui génère une chaîne unique (ex : 656b3ef2c6a9b)
                // $imageFile->guessExtension() → devine automatiquement l’extension (jpg, png, etc.)
                // Le point (.) sert à concaténer les deux chaînes pour former un nom de fichier complet
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_projet'),
                        $newFilename
                    );
                     $categoryProjet ->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors du téléchargement de l\'image.');
                }
            }
            $entityManager->persist($categoryProjet);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_projet/new.html.twig', [
            'category_projet' => $categoryProjet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_projet_show', methods: ['GET'])]
    public function show(CategoryProjet $categoryProjet): Response
    {
        return $this->render('category_projet/show.html.twig', [
            'category_projet' => $categoryProjet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryProjet $categoryProjet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryProjetType::class, $categoryProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('image')->getData();
                if ($imageFile) {
                    $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                    try {
                        $imageFile->move(
                            $this->getParameter('images_projet'),
                            $newFilename
                        );
                        $categoryProjet->setImage($newFilename);
                    } catch (FileException $e) {
                        $this->addFlash('danger', 'Erreur lors du téléchargement de l\'image.');
                    }
                }
            $entityManager->flush();
            

            return $this->redirectToRoute('app_category_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_projet/edit.html.twig', [
            'category_projet' => $categoryProjet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_projet_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryProjet $categoryProjet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryProjet->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categoryProjet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_projet_index', [], Response::HTTP_SEE_OTHER);
    }
}
