<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SidebarPartnersProvider;
use App\Form\ContactFormType;
use App\Entity\ContactForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
class ContactController extends AbstractController
{
    #[route(path: "/contact", name: "contact")]
    public function home (SidebarPartnersProvider $side, Request $request, EntityManagerInterface $entityManager): Response
    {
        $rdmPartners = $side->getRandomPartners();
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $reponseContact = new ContactForm();
            $reponseContact->setNameContact($data['name']);
            $reponseContact->setSurnameContact($data['lastName']);
            $reponseContact->setEmailContact($data['email']);
            $reponseContact->setContentMessage($data['message']);
            $reponseContact->setDateMessage(new \DateTime());

            $entityManager->persist($reponseContact);
            $entityManager->flush();
            $form = $this->createForm(ContactFormType::class); // réinitialiser le formulaire
            $session = $request->getSession();
            $session->getFlashBag()->add('success', 'Votre message a été envoyé avec succès.');
        }

        return $this->render('contact/index.html.twig', [
            'rdmPartners' => $rdmPartners,
            'form' => $form->createView(),
        ]);
    }
}