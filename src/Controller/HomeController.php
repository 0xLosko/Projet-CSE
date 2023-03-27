<?php

namespace App\Controller;

use App\Entity\ContentPage;
use App\Form\HomeType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Page;
class HomeController extends AbstractController
{
    #[route(path: "/accueil", name: "home")]
    public function home (ManagerRegistry $em): Response
    {
        $currentPage = $em->getRepository(Page::class)->findOneBy(['namePage' => 'Accueil']);
        $homeContent = $em->getRepository(ContentPage::class)->findOneBy(['page' => $currentPage])->getTextContent();

        return $this->render('home/index.html.twig', [
            'homeContent' => $homeContent,
        ]);
    }
    #[Route('/backoffice/gerer-accueil', name: 'manage_home')]
    public function manageHome(ManagerRegistry $mr, Request $request,EntityManagerInterface $em): Response
    {
        $responseContent = new ContentPage();

        $currentPage = $mr->getRepository(Page::class)->findOneBy(['namePage' => 'Accueil']);
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