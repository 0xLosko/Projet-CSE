<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\SidebarPartnersProvider;

class HomeController extends AbstractController
{
     #[route(path: "/", name: "home")]
     public function home (ManagerRegistry $em, SidebarPartnersProvider $side): Response
     {
         $rdmPartners = $side->getRandomPartners($em);
         return $this->render('home/index.html.twig', [
             'rdmPartners' => $rdmPartners,
         ]);
     }
}