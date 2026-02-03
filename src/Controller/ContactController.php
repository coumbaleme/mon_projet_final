<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        // Création du formulaire Symfony
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('message', TextareaType::class, ['label' => 'Message'])
            ->add('envoyer', SubmitType::class, ['label' => 'Envoyer', 'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            
           

            $emailMessage = (new Email())
                ->from('moussasanne02@gmail.com')
                
                ->to('moussasanne02@gmail.com') // remplace par ton email
                ->replyTo($data['email'])
                ->subject('Message depuis le formulaire de contact')
                ->text(
                    "Nom: {$data['nom']}\n".
                    "Email: {$data['email']}\n".
                    "Message:\n{$data['message']}"
                );

            $mailer->send($emailMessage);

            $this->addFlash('success', 'Votre message a été envoyé !');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
}
