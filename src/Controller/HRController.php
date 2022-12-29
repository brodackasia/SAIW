<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HRService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/hr')]
class HRController extends AbstractController
{
    private HRService $HRService;

    public function __construct(HRService $HRService)
    {
        $this->HRService = $HRService;
    }

    //WALIDACJA PATIENT ID
    public function patientIdValidation(int $patientId): bool
    {
        if (
            is_null($patientId)
            || !is_numeric($patientId)
        )
            return false;
        else
            return true;
    }

    //WALIDACJA TO AND FROM PARAMETERS
    public function fromAndToValidation(string $from, string $to): bool
    {
        //spr czy jest dobry format, czy da sie utworzyc date z tego co w requescie
        // zwraca datetime lub false
        if (
            is_null($to)
            || is_null($from)
            || !DateTime::createFromFormat('Y-m-d H:i', $from)
            || !DateTime::createFromFormat('Y-m-d H:i', $to)
        )
            return false;
        else
            return true;
    }

    //CHART AND HRV
    #[Route('/analysis/{type}', name: 'hr.analysis', methods: ['GET'])]
    public function analysisHR(Request $request, string $type): Response
    {
        //pobieranie parametru z requestu
        $patientId = $request->query->get('patientId');
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        //wywolanie funkcji walidacji x2
        if (
            !$this->patientIdValidation((int)($patientId))
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (
            !$this->fromAndToValidation($from, $to)
        ) {
            return new Response(
                'Invalid parameter "from" or "to"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $to = DateTime::createFromFormat('Y-m-d H:i', $to);
        $from = DateTime::createFromFormat('Y-m-d H:i', $from);

        return new JsonResponse(
            $this->HRService->getAnalysisHR($type, $from, $to, (int)$patientId),
       );
    }

    //CURRENT
    #[Route('/current/{type}', name: 'hr.current', methods: ['GET'])]
    public function currentHr(Request $request, string $type): Response
    {
        $patientId = $request->query->get('patientId');

        //wywolanie funkcji walidacji
        if (
            !$this->patientIdValidation((int)($patientId))
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse([
            'hr' => $this->HRService->getCurrentHR($type,(int)$patientId)
        ]);
    }


    //MINIMUM
    #[Route('/minimum/{type}', name: 'hr.minimum', methods: ['GET'])]
    public function minimumHr(Request $request, string $type): Response
    {
        //pobieranie parametru z requestu
        $patientId = $request->query->get('patientId');
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        //wywolanie funkcji walidacji x2
        if (
            !$this->patientIdValidation((int)($patientId))
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (
            !$this->fromAndToValidation($from, $to)
        ) {
            return new Response(
                'Invalid parameter "from" or "to"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $to = DateTime::createFromFormat('Y-m-d H:i', $to);
        $from = DateTime::createFromFormat('Y-m-d H:i', $from);

        return new JsonResponse([
            'hr' => $this->HRService->getMinimumHR($type, $from, $to, (int)$patientId)
        ]);
    }

    //MAXIMUM
    #[Route('/maximum/{type}', name: 'hr.maximum', methods: ['GET'])]
    public function maximumHr(Request $request, string $type): Response
    {
        //pobieranie parametru z requestu
        $patientId = $request->query->get('patientId');
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        //wywolanie funkcji walidacji x2
        if (
            !$this->patientIdValidation((int)($patientId))
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (
            !$this->fromAndToValidation($from, $to)
        ){
            return new Response(
                'Invalid parameter "from" or "to"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $to = DateTime::createFromFormat('Y-m-d H:i', $to);
        $from = DateTime::createFromFormat('Y-m-d H:i', $from);

        return new JsonResponse([
            'hr' => $this->HRService->getMaximumHR($type, $from, $to, (int)$patientId)
        ]);
    }

    //AVERAGE
    #[Route('/average/{type}', name: 'hr.average', methods: ['GET'])]
    public function averageHr(Request $request, string $type): Response
    {
        //pobieranie parametru z requestu
        $patientId = $request->query->get('patientId');
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        //wywolanie funkcji walidacji x2
        if (
            !$this->patientIdValidation((int)($patientId))
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (
            !$this->fromAndToValidation($from, $to)
        ){
            return new Response(
                'Invalid parameter "from" or "to"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $to = DateTime::createFromFormat('Y-m-d H:i', $to);
        $from = DateTime::createFromFormat('Y-m-d H:i', $from);

        return new JsonResponse([
            'hr' => $this->HRService->getAverageHR($type, $from, $to, (int)$patientId)
        ]);
    }
}