<?php

namespace App\Controller;

use App\Entity\ContentPage;
use App\Entity\Offer;
use App\Entity\Page;
use App\Form\HomeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    #[route(path: "/accueil", name: "home")]
    public function home (ManagerRegistry $em,Request $request): Response
    {
        $currentPage = $em->getRepository(Page::class)->findOneBy(['namePage' => 'home']);
        $homeContent = $em->getRepository(ContentPage::class)->findOneBy(['page' => $currentPage])->getTextContent();

        //search page in url
        $page = $request->query->getInt('page', 1);
        $limitedOffers = $em->getRepository(Offer::class)->findOfferPaginated($page, 0,3);

        return $this->render('home/index.html.twig', [
            'homeContent' => $homeContent,
            'limitedOffers' => $limitedOffers,
        ]);
    }

    #[Route('/backoffice/gerer-accueil', name: 'manage_home')]
    public function manageHome(ManagerRegistry $mr, Request $request,EntityManagerInterface $em): Response
    {
        $responseContent = new ContentPage();

        $currentPage = $mr->getRepository(Page::class)->findOneBy(['namePage' => 'home']);
        $oldHomeContent = $mr->getRepository(ContentPage::class)->findOneBy(['page' => $currentPage]);

        $form = $this->createForm(HomeType::class, $responseContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $oldHomeContent->setTextContent($responseContent->getTextContent());
            $em->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add('success', 'cette modification a été prise en compte.');
        }

        return $this->render('security/backoffice/manage_home/index.html.twig', [
            'homeContent' => $oldHomeContent->getTextContent(),
            'form' => $form->createView(),
        ]);
    }
}