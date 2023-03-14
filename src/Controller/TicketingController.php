<?php

namespace App\Controller;

use App\Service\SidebarPartnersProvider;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketingController extends AbstractController
{
    #[Route('/ticketing', name: 'ticketing')]
    public function index(ManagerRegistry $em, SidebarPartnersProvider $side): Response
    {
        $rdmPartners = $side->getRandomPartners($em);
        return $this->render('ticketing/index.html.twig', [
            'rdmPartners' => $rdmPartners,
        ]);
    }
}
