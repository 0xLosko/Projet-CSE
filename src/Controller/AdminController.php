<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    #[Route('/backoffice/gerer-les-administrateurs', name: 'manage_admins')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $allAdmins = $entityManager->getRepository(User::class)->findAll();

        return $this->render('security/backoffice/manage_admins/index.html.twig',[
            'admins' => $allAdmins,
        ]);
    }

    #[Route('backoffice/gerer-les-administrateurs/nouveau', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'isModify' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(["ROLE_ADMIN"]);
            $userRepository->save($user, true);

            return $this->redirectToRoute('manage_admins', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/backoffice/manage_admins/new.html.twig', [
            'admin' => $user,
            'form' => $form,
        ]);
    }

    #[Route('backoffice/gerer-les-administrateurs/{id}/modifier', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'isModify' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userRepository->save($user, true);

            return $this->redirectToRoute('manage_admins', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/backoffice/manage_admins/edit.html.twig', [
            'admin' => $user,
            'form' => $form,
        ]);
    }

    #[Route('backoffice/gerer-les-administrateurs/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository, Security $security): Response
    {
        $currentUser = $security->getUser(); // Obtenir l'utilisateur actuel

        if ($currentUser === $user) {
            $this->addFlash('danger', 'Vous ne pouvez pas supprimer votre compte.');

            return $this->redirectToRoute('manage_admins');
        }

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('manage_admins', [], Response::HTTP_SEE_OTHER);
    }
}
