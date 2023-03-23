<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use App\Repository\FileRepository;
use App\Service\SidebarPartnersProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;


class PartnershipController extends AbstractController
{
    #[Route('/partenariats', name: 'partnership')]
    public function index(ManagerRegistry $em): Response
    {
        $partners = $em->getRepository(Partner::class)->getPartners(true);
        return $this->render('partnership/index.html.twig', [
            'partners' => $partners,
        ]);
    }

    #[Route('/partenariats/tous-les-partenaires/', name: 'partnership-all')]
    public function allPartners(ManagerRegistry $em,  SidebarPartnersProvider $side): Response
    {
        $partners = $em->getRepository(Partner::class)->getPartners(false);
        return $this->render('partnership/index.html.twig', [
            'partners' => $partners,
        ]);
    }
    #[Route('backoffice/gerer-les-partenaires', name: 'manage_partners', methods: ['GET'])]
    public function manage_partners(PartnerRepository $partnerRepository): Response
    {
        return $this->render('security/backoffice/manage_partners/index.html.twig', [
            'partners' => $partnerRepository->findAll(),
        ]);
    }

    #[Route('backoffice/gerer-les-partenaires/nouveau', name: 'app_partner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PartnerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $Response = $form->getData();
            //file insert

            $fileResponse = $Response['file'];
            $originalFileName = pathinfo($fileResponse->getClientOriginalName(), PATHINFO_FILENAME);
            $file = new File();
            $file->setOriginalName($fileResponse->getClientOriginalName());
            $file->setFileName($Response['nameFile']);
            $file->setAltFile($Response['nameAltFile']);
            $file->setSizeFile($fileResponse->getSize());
            $file->setDateFile(new \DateTime());

            $safeFilename = $slugger->slug($originalFileName);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$fileResponse->guessExtension();
            try {
                $fileResponse->move(
                    $this->getParameter('file_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                dd('Erreur lors de l\'insertion de l\'image, contactez un administrateur' . $e);
            }

            $file->setPathFile($newFilename);
            $em->persist($file);
            $em->flush();
            //insert partner
            $partner = new Partner();
            $partner ->setName($Response['name']);
            $partner ->setDescription($Response['description']);
            $partner ->setLink($Response['link']);
            $partner ->setIdFile($file);

            $em->persist($partner);
            $em->flush();

            return $this->redirectToRoute('manage_partners', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('security/backoffice/manage_partners/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('backoffice/gerer-les-partenaires/{id}/edit', name: 'app_partner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, PartnerRepository $partnerRepository): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerRepository->save($partner, true);

            return $this->redirectToRoute('manage_partners', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/manage_partners/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('backoffice/gerer-les-partenaires/{id}', name: 'app_partner_delete', methods: ['POST'])]
    public function delete(Request $request, Partner $partner, PartnerRepository $partnerRepository, FileRepository $fileRepository): Response
    {
        $file = $partner->getIdFile()->getPathFile();
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            unlink($this->getParameter('file_directory') . '/' . $file);
            $fileRepository->remove($partner->getIdFile(), true);
            $partnerRepository->remove($partner, true);
        }

        return $this->redirectToRoute('manage_partners', [], Response::HTTP_SEE_OTHER);
    }
}
