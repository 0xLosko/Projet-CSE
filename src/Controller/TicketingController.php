<?php

namespace App\Controller;


use App\Entity\File;
use App\Entity\Offer;
use App\Entity\User;
use App\Form\OfferType;
use App\Repository\FileRepository;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
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

    #[Route('/backoffice/gerer-les-offres', name: 'manage_offers')]
    public function manageOffers(EntityManagerInterface $em): Response
    {
        $offers = $em->getRepository(Offer::class)->findAll();

        return $this->render('security/backoffice/manage_offers/index.html.twig',[
            'offers' => $offers,
        ]);
    }
    #[Route('backoffice/gerer-les-offres/nouvelle-offre', name: 'app_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OfferRepository $offerRepository, PictureService $pictureService): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $response = $form->getData();
            //insert offer
            $offer->setTitleOffer($response['titleOffer']);
            $offer->setDescriptionOffer($response['descriptionOffer']);
            $offer->setLinkOffer($response['linkOffer']);
            $offer->setTypeOffer($response['typeOffer']);
            $offer->setNumberPlaces($response['numberPlaces']);
            $offer->setSortNumber($response['sortNumber']);
            $offer->setStartDateDisplay($response['startDateDisplay']);
            $offer->setEndDateDisplay($response['endDateDisplay']);
            $offer->setStartDateValid($response['startDateValid']);
            $offer->setEndDateValid($response['endDateValid']);
            $offerRepository->save($offer, true);

            //insert picture
            for($i = 1; $i <= 4; $i++){
                if(isset($response['file'.$i])){
                    $pictureService->add($response['file'.$i], null, null , $offer);
                }
            }

            return $this->redirectToRoute('manage_offers', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/backoffice/manage_offers/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('backoffice/gerer-les-offres/{id}/modifier', name: 'app_offer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer, OfferRepository $offerRepository): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offerRepository->save($offer, true);

            return $this->redirectToRoute('manage_offers', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/backoffice/manage_offers/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('backoffice/gerer-les-offres/{id}/supprimer', name: 'app_offer_delete', methods: ['POST'])]
    public function delete(Request $request, int $id, EntityManagerInterface $em, OfferRepository $offerRepository, FileRepository $fileRepository): Response
    {
        $currentOffer = $em->getRepository(Offer::class)->findBy(['id' => $id])[0];
        $relatedFiles = $em->getRepository(File::class)->findBy(['offer' => $currentOffer]);
        $pattern = "/\/uploads\/file\//";

        if ($this->isCsrfTokenValid('delete'.$currentOffer->getId(), $request->request->get('_token'))) {
            foreach ($relatedFiles as $rf){
                $rfs = $rf->getPathFile();
                $newFile = preg_replace($pattern, "", $rfs);
                unlink($this->getParameter('file_directory') . '/' . $newFile);
                $fileRepository->remove($rf, true);
            }
            $offerRepository->remove($currentOffer, true);
        }

        return $this->redirectToRoute('manage_offers', [], Response::HTTP_SEE_OTHER);
    }
}
