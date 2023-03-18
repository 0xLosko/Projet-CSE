<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SidebarPartnersProvider;
use Symfony\Component\HttpFoundation\Request;
class HomeController extends AbstractController
{
     #[route(path: "/", name: "home")]
     public function home (SidebarPartnersProvider $side, Request $request): Response
     {
         $rdmPartners = $side->getRandomPartners();
         return $this->render('home/index.html.twig', [
             'rdmPartners' => $rdmPartners,
         ]);
     }
}