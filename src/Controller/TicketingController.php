<?php

namespace App\Controller;


use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketingController extends AbstractController
{
    #[Route('/billeterie', name: 'ticketing', methods: ['GET'])]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        //search page in url
        $page = $request->query->getInt('page', 1);
        //search typeoffers in url
        $typeOffers = $request->query->getInt('typeoffre', 3);

        $offers = $em->getRepository(Offer::class)->findOfferPaginated($page, $typeOffers,1);
        return $this->render('ticketing/index.html.twig',[
            'Offers' => $offers,
            'request' => $request,
            'typeOffers' => $typeOffers,
        ]);
    }
}
