<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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
    public function updateProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupère l'utilisateur connecté

        // Récupérez les données du formulaire
        $username = $request->request->get('username');
        $email = $request->request->get('email');


        // Mettez à jour l'entité User
        $user->setUsername($username);
        $user->setEmail($email);

        // Enregistrez les modifications
        $entityManager->persist($user);
        $entityManager->flush();

        // Redirigez vers la page de profil avec un message de confirmation
        $this->addFlash('success', 'Profil mis à jour avec succès !');
        return $this->redirectToRoute('app_profile');
    }
}
