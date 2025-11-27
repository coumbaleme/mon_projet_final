<?php

namespace App\Controller;

use App\Entity\CategoryMetier;
use App\Form\CategoryMetier1Type;
use App\Repository\CategoryMetierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorie/metier')]
final class CategoryMetierController extends AbstractController
{
    #[Route(name: 'app_category_metier_index', methods: ['GET'])]
    public function index(CategoryMetierRepository $categoryMetierRepository): Response
    {
        return $this->render('category_metier/index.html.twig', [
            'category_metiers' => $categoryMetierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_metier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoryMetier = new CategoryMetier();
        $form = $this->createForm(CategoryMetier1Type::class, $categoryMetier);
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
                        $this->getParameter('images_metier'),
                        $newFilename
                    );
                    $categoryMetier->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors du téléchargement de l\'image.');
                }
            }

            $entityManager->persist($categoryMetier);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_metier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category_metier/new.html.twig', [
            'category_metier' => $categoryMetier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_metier_show', methods: ['GET'])]
    public function show(CategoryMetier $categoryMetier): Response
    {
        return $this->render('category_metier/show.html.twig', [
            'category_metier' => $categoryMetier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_metier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryMetier $categoryMetier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryMetier1Type::class, $categoryMetier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    /** @var UploadedFile|null $imageFile */

$imageFile = $form->get('image')->getData();

if ($imageFile) {
                // uniqid() → fonction PHP qui génère une chaîne unique (ex : 656b3ef2c6a9b)
                // $imageFile->guessExtension() → devine automatiquement l’extension (jpg, png, etc.)
                // Le point (.) sert à concaténer les deux chaînes pour former un nom de fichier complet
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
 
                try {
                    // $this->getParameter() → méthode Symfony pour lire un paramètre défini dans services.yaml
                    // Ici, on lit la valeur de "images_directory" (chemin vers le dossier public/images)
 
                    // move() → méthode de l’objet UploadedFile
                    // Elle déplace le fichier depuis le dossier temporaire vers le bon dossier sur le serveur
                    $imageFile->move(
                        $this->getParameter('images_metier'), // Dossier de destination
                        $newFilename // Nom du fichier à enregistrer
                    );
 
                    // $produit->setImg($newFilename)
                    // On met à jour la propriété "img" du produit avec le nom du nouveau fichier
                    $categoryMetier->setImage($newFilename);
                } catch (FileException $e) {
                    // Si une erreur se produit lors du déplacement du fichier, on affiche un message temporaire à l’utilisateur
                    // addFlash() est une méthode de Symfony pour afficher des messages dans les vues
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                }
            }
                         $entityManager->flush();
            // persist() n'est pas necessaire ici car Doctrine a deja l'objet $produit
        }
 

   


        return $this->render('category_metier/edit.html.twig', [
            'category_metier' => $categoryMetier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_metier_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryMetier $categoryMetier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryMetier->getId(), $request->getPayload()->getString('_token'))) {

              // Récupère le nom de l’image
        $image =$categoryMetier->getImage();
 
        if ($image) {
            $imagePath = $this->getParameter('images_metier') . '/' . $image;
 
            // Supprime le fichier image du système de fichiers
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
            $entityManager->remove($categoryMetier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_metier_index', [], Response::HTTP_SEE_OTHER);
    }
}
