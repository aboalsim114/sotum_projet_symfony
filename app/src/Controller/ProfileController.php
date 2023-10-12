<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route("/profile/update", name: "profile_update", methods: ["POST"])]
    public function updateProfile(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response

    {
        $user = $this->getUser(); // Récupère l'utilisateur connecté

        // Récupérez les données du formulaire
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $confirmPassword = $request->request->get('confirm_password');

        // Mettez à jour l'entité User
        $user->setUsername($username);
        $user->setEmail($email);

        if ($password && $confirmPassword) {
            if ($password !== $confirmPassword) {
                $this->addFlash('error', 'The passwords do not match.');
                return $this->redirectToRoute('app_profile');
            }
    
            $user->setPassword($passwordHasher->hashPassword($user, $password));
        }

        // Enregistrez les modifications
        $entityManager->persist($user);
        $entityManager->flush();

        // Redirigez vers la page de profil avec un message de confirmation
        $this->addFlash('success', 'Profil mis à jour avec succès !');
        return $this->redirectToRoute('app_profile');
    }
}
