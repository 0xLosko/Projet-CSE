<?php

namespace App\Controller;

use App\Service\SidebarPartnersProvider;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(ManagerRegistry $em, SidebarPartnersProvider $side): Response
{
    $rdmPartners = $side->getRandomPartners($em);
    return $this->render('contact/index.html.twig', [
        'rdmPartners' => $rdmPartners,
    ]);
}
}
