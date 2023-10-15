<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Repository\MotsRepository;

class GamepageController extends AbstractController
{
    
    

    #[Route('/gamepage', name: 'app_gamepage')]
    public function index(MotsRepository $motsRepository ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Récupérez tous les mots de la table Mots
        $motsFromDb = $motsRepository->findAll();
        $this->validPhrases = array_map(function($mot) {
            return $mot->getMot(); 
        }, $motsFromDb);

        shuffle($this->validPhrases);

        return $this->render('gamepage/index.html.twig', [
            'controller_name' => 'GamepageController',
            'rows' => 6,
            'columns' => 8,
            'validPhrases' => $this->validPhrases,
            'lastValidatedRow' => $this->getLastValidatedRow()
        ]);
    }

    private function getLastValidatedRow(): int
    {
        return 0;
    }

    #[Route('/validate-row', name: 'validate_row', methods: ["POST"])]
    public function validateRow(Request $request): Response
    {
        $rowData = $request->request->get('row_data');
        $rowIndex = (int) $request->request->get('row_index');

        if (isset($this->validPhrases[$rowIndex])) {
            $isValid = $rowData === $this->validPhrases[$rowIndex];
        } else {
            $isValid = false;
        }

        return new JsonResponse(['isValid' => $isValid]);
    }
}
