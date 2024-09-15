<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        // Vérifiez que l'utilisateur a le rôle ROLE_ADMIN
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have the required role to access this page.');
        }

        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/create-user', name: 'admin_create_user')]
    public function createUser(Request $request): Response
    {
        // Vérifiez que l'utilisateur a le rôle ROLE_ADMIN
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have the required role to access this page.');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ajoutez le rôle ROLE_EMPLOYE
            $user->setRoles(['ROLE_EMPLOYE']);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'User created successfully.');

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/create_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}