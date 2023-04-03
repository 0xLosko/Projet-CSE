<?php

namespace App\Controller;


use App\Entity\File;
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
        $typeOffers = $request->query->getInt('typeoffre', 2);

        $offers = $em->getRepository(Offer::class)->findOfferPaginated($page, $typeOffers,4);
        return $this->render('ticketing/index.html.twig',[
            'Offers' => $offers,
            'request' => $request,
            'typeOffers' => $typeOffers,
        ]);
    }
    #[Route('/billeterie/{id}', name: 'showOffer', methods: ['GET'])]
    public function showOneOffer(EntityManagerInterface $em, int $id): Response
    {
        $offer = $em->getRepository(Offer::class)->findBy(['id' => $id]);
        $filesOffer= $em->getRepository(File::class)->findBy(['offer' => $offer]);

        return $this->render('ticketing/one-offer.html.twig',[
            'offer' => $offer[0],
            'fileOffers' =>$filesOffer,
        ]);
    }
}
