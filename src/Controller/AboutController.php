<?php

namespace App\Controller;

use App\Entity\ContentPage;
use App\Entity\File;
use App\Entity\Member;
use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/a-propos', name: 'about')]
    public function about(ManagerRegistry $em): Response
    {
        $members = $em->getRepository(Member::class)->findAll();
        foreach ($members as $member) {
            $member->setFile($em->getRepository(File::class)->findOneBy(['id' => $member->getFile()->getId()]));
        }

        $currentPage = $em->getRepository(Page::class)->findOneBy(['namePage' => 'about']);
        $aboutActions = $em->getRepository(ContentPage::class)->findOneBy(
            array('page' => $currentPage, 'positionPage' => 'actions')
        );
        $aboutRule = $em->getRepository(ContentPage::class)->findOneBy(
            array('page' => $currentPage, 'positionPage' => 'rule')
        );
        $aboutAdditionalInfo = $em->getRepository(ContentPage::class)->findOneBy(
            array('page' => $currentPage, 'positionPage' => 'additional-info')
        );

        $actionsLines = explode("\n", $aboutActions->getTextContent());
        $actionsLines = array_diff($actionsLines, [""]);

        $addInfo = explode("\n", $aboutAdditionalInfo->getTextContent());
        $addInfo = array_diff($addInfo, [""]);


        return $this->render('about/index.html.twig', [
            'members' => $members,
            'actions' => $actionsLines,
            'rule' => $aboutRule,
            'additional_info' => $addInfo,
        ]);
    }
}
