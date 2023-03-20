<?php

namespace App\Controller;

use App\Entity\ContentPage;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Page;
class HomeController extends AbstractController
{
    #[route(path: "/", name: "home")]
    public function home (ManagerRegistry $em): Response
    {
        $currentPage = $em->getRepository(Page::class)->findOneBy(['namePage' => 'Accueil']);
        $homeContent = $em->getRepository(ContentPage::class)->findOneBy(['page' => $currentPage])->getTextContent();

        return $this->render('home/index.html.twig', [
            'homeContent' => $homeContent,
        ]);
    }
}