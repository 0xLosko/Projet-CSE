<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;
use App\Entity\ContactForm;
use App\Entity\NewsletterRegistration;
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

            if ($data["subscribeToNewsletter"] == true) {
                $subscriber = new NewsletterRegistration();
                $subscriber->setEmailSubscriber($data['email']);
                $subscriber->setDateSubscriber(new \DateTime());
                $subscriber->setCguAccepted($data['cgu']);

                $entityManager->persist($subscriber);
                $entityManager->flush();
            }

            $session->getFlashBag()->add('success', 'Votre message a été envoyé avec succès.');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[route(path: "backoffice/consulter-les-messages/", name:"manage_message")]
    public  function viewMessages (Request $request, EntityManagerInterface $em): Response
    {
        $messages = $em->getRepository(ContactForm::class)->findAll();

        return $this->render('security/backoffice/manage_message/index.html.twig', [
        'messages' => $messages,
    ]);
    }
}