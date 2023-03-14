<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Partner;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
     #[route(path: "/", name: "index")]
     public function index (ManagerRegistry $em): Response
     {
         $partners = $em->getRepository(Partner::class)->findAll();
         $randomKeys = array_rand($partners, 3);
         foreach($partners as $key => $partner){
             if(!in_array($key, $randomKeys)){
                 unset($partners[$key]);
             }
         }
         return $this->render('base.html.twig', [
             'rdmPartners' => $partners,
         ]);
     }
}