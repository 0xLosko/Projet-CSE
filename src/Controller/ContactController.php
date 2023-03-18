<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\SidebarPartnersProvider;
use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
class ContactController extends AbstractController
{
    #[route(path: "/contact", name: "contact")]
    public function home (ManagerRegistry $em, SidebarPartnersProvider $side, Request $request): Response
    {
        $rdmPartners = $side->getRandomPartners($em);
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);
        }

        return $this->render('contact/index.html.twig', [
            'rdmPartners' => $rdmPartners,
            'form' => $form->createView(),
        ]);
    }
}