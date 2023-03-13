<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Partner;

class PartnershipController extends AbstractController
{
    #[Route('/partenariats', name: 'partnership')]
    public function index(ManagerRegistry $em): Response
    {
        $partners = $em->getRepository(Partner::class)->getPartners(true);
        return $this->render('partnership/index.html.twig', [
                        'partners' => $partners,
        ]);
    }

    #[Route('/partenariats/tous-les-partenaires/', name: 'partnership-all')]
        public function allPartnership(ManagerRegistry $em): Response
        {
            $partners = $em->getRepository(Partner::class)->getPartners(false);
            return $this->render('partnership/index.html.twig', [
                'partners' => $partners,
            ]);
        }
}
