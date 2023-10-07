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

    private function getLastValidatedRow(): int
    {
        $session = $this->get('session');
        $validatedRows = $session->get('validatedRows', []);

        // Retourne le dernier index validé ou -1 si aucun n'est validé.
        return end($validatedRows) ?: -1;
    }


    #[Route('/gamepage', name: 'app_gamepage')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('gamepage/index.html.twig', [
            'controller_name' => 'GamepageController',
            'rows' => 6,
            'columns' => 8,
            'validPhrases' => $this->validPhrases,
            'lastValidatedRow' => $this->getLastValidatedRow()

        ]);
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

        if ($isValid) {
            $session = $this->get('session');
            $validatedRows = $session->get('validatedRows', []);
            $validatedRows[] = $rowIndex;
            $session->set('validatedRows', $validatedRows);
        }

        return new JsonResponse(['isValid' => $isValid]);
    }
}
