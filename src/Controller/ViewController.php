<?php

namespace App\Controller;

use App\Service\PatientsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{

    private PatientsService $patientsService;

    public function __construct(PatientsService $patientsService)
    {
        $this->patientsService = $patientsService;
    }

    #[Route('/view', name: 'view')]
    public function index(): Response
    {
        return $this->render(
            'view/index.html.twig',
            [
                'patients' => $this->patientsService->getPatientsNames(
                    $this->getUser()->getId()
                )
            ]
        );
    }
}
