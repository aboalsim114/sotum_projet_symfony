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
        
        // // Récupérez les scores
        // $scores = $scoreRepository->findBy([], ['score' => 'DESC'], 10);
        // $formattedScores = array_map(function($score) {
        //     return [
        //         'playerName' => $score->getPlayer()->getName(),
        //         'score' => $score->getScore()
        //     ];
        // }, $scores);
        
        return $this->render('gamepage/index.html.twig', [
            'controller_name' => 'GamepageController',
            'rows' => 6,
            'columns' => 8,
            'validPhrases' => $this->validPhrases,
            'lastValidatedRow' => $this->getLastValidatedRow()
        ]);
    }

    

    // #[Route('/player-scores', name: 'player_scores')]
    // public function playerScores(): JsonResponse
    // {
    //     $joueurs = $this->getDoctrine()->getRepository(Joueur::class)->findAll();
    //     $scores = [];

    //     foreach ($joueurs as $joueur) {
    //         $scores[] = [
    //             'nom' => $joueur->getNom(),
    //             'score' => $joueur->getScore(),
    //         ];
    //     }

    //     return new JsonResponse($scores);
    // }

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
