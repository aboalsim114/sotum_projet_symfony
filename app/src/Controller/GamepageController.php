<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GamepageController extends AbstractController
{
    #[Route('/gamepage', name: 'app_gamepage')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('gamepage/index.html.twig', [
            'controller_name' => 'GamepageController',
            'rows' => 6,
            'columns' => 8,
        ]);
    }
}
