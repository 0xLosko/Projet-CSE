<?php

namespace App\Controller;

use App\Service\SidebarPartnersProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Partner;

class PartnershipController extends AbstractController
{
    #[Route('/partenariats', name: 'partnership')]
    public function index(ManagerRegistry $em,  SidebarPartnersProvider $side): Response
    {
        $partners = $em->getRepository(Partner::class)->getPartners(true);
        $rdmPartners = $side->getRandomPartners($em);
        return $this->render('partnership/index.html.twig', [
                        'partners' => $partners,
                        'rdmPartners' => $rdmPartners,
        ]);
    }

    #[Route('/partenariats/tous-les-partenaires/', name: 'partnership-all')]
        public function allPartners(ManagerRegistry $em,  SidebarPartnersProvider $side): Response
        {
            $partners = $em->getRepository(Partner::class)->getPartners(false);
            $rdmPartners = $side->getRandomPartners($em);
            return $this->render('partnership/index.html.twig', [
                'partners' => $partners,
                'rdmPartners' => $rdmPartners,
            ]);
        }
}
