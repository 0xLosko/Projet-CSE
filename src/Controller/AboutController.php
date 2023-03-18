<?php

namespace App\Controller;

use App\Service\SidebarPartnersProvider;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'about')]
    public function index(SidebarPartnersProvider $side): Response
    {
        $rdmPartners = $side->getRandomPartners();
        return $this->render('about/index.html.twig', [
            'rdmPartners' => $rdmPartners,
        ]);
    }
}
