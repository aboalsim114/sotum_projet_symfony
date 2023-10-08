<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GamepageController extends AbstractController
{
    private $validPhrases = [
        "plongeon",
        "travaux",
        "Chocolat",
        "tendance",
        "Chocolat",
        "tendance",

    ];

    #[Route('/gamepage', name: 'app_gamepage')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Mélanger l'ordre des phrases valides
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
        // Pour cet exemple, je vais simplement retourner 0.
        // Vous pouvez remplacer cette logique pour déterminer la dernière ligne validée.
        return 0;
    }


    // #[Route('/gamepage', name: 'app_gamepage')]
    // public function index(): Response
    // {
    //     $this->denyAccessUnlessGranted('ROLE_USER');
    //     return $this->render('gamepage/index.html.twig', [
    //         'controller_name' => 'GamepageController',
    //         'rows' => 6,
    //         'columns' => 8,
    //         'validPhrases' => $this->validPhrases,
    //         'lastValidatedRow' => $this->getLastValidatedRow()

    //     ]);
    // }

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
