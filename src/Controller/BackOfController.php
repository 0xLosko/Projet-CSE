<?php

namespace App\Controller;

use App\Entity\ContentPage;
use App\Entity\Page;
use App\Form\HomeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
class BackOfController extends AbstractController
{
    #[Route('/backoffice', name: 'backoffice')]
    public function index(): Response
    {
        return $this->render('security/backoffice/base.html.twig');
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