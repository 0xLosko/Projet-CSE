<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnershipController extends AbstractController
{
    #[Route('/partnership', name: 'partnership')]
    public function index(): Response
    {
        return $this->render('partnership/index.html.twig', [
            'controller_name' => 'PartnershipController',
        ]);
    }
}
