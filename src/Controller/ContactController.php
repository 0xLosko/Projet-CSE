<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;
use App\Entity\ContactForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
class ContactController extends AbstractController
{
    #[route(path: "/contact", name: "contact")]
    public function home (Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $responseContact = new ContactForm();
            $responseContact->setNameContact($data['name']);
            $responseContact->setSurnameContact($data['lastName']);
            $responseContact->setEmailContact($data['email']);
            $responseContact->setContentMessage($data['message']);
            $responseContact->setDateMessage(new \DateTime());

            $entityManager->persist($responseContact);
            $entityManager->flush();
            $form = $this->createForm(ContactFormType::class); // réinitialiser le formulaire
            $session = $request->getSession();
            $session->getFlashBag()->add('success', 'Votre message a été envoyé avec succès.');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}