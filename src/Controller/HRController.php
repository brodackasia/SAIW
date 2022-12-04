<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HRService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    //CURRENT
    #[Route('/current/{type}', name: 'hr.current', methods: ['GET'])]
    public function currentHr(Request $request, string $type): Response
    {
        $patientId = $request->query->get('patientId');

        //wywolanie funkcji walidacji x2
        if (
            $this->patientIdValidation((int)($patientId)) === false
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        return new Response(
            (string)$this->HRService->getCurrentHR($type, (int)$patientId)
        );
    }

    //WALIDACJA
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

    //WALIDACJA
    public function fromAndToValidation(string $from, string $to): bool
    {
        //spr czy jest dobry format, czy da sie utworzyc date z tego co w requescie zwraca datetime lub false
        if (
            is_null($to)
            || is_null($from)
            || DateTime::createFromFormat('Y-m-d H:i:s', $from) === false
            || DateTime::createFromFormat('Y-m-d H:i:s', $to) === false
        )
            return false;
        else
            return true;
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
            $this->patientIdValidation((int)($patientId)) === false
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (
            $this->fromAndToValidation($from, $to) === false
        ) {
            return new Response(
                'Invalid parameter "from" or "to"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $to = DateTime::createFromFormat('Y-m-d H:i:s', $to);
        $from = DateTime::createFromFormat('Y-m-d H:i:s', $from);

        return new Response(
            (string) $this->HRService->getMinimumHR($type, $from, $to, (int)$patientId)
        );
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
            $this->patientIdValidation((int)($patientId)) === false
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (
            $this->fromAndToValidation($from, $to) === false
        ){
            return new Response(
                'Invalid parameter "from" or "to"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $to = DateTime::createFromFormat('Y-m-d H:i:s', $to);
        $from = DateTime::createFromFormat('Y-m-d H:i:s', $from);

        return new Response(
            (string) $this->HRService->getMaximumHR($type, $from, $to, (int)$patientId)
        );
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
            $this->patientIdValidation((int)($patientId)) === false
        ) {
            return new Response(
                'Invalid parameter "patientId"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        if (
            $this->fromAndToValidation($from, $to) === false
        ){
            return new Response(
                'Invalid parameter "from" or "to"!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $to = DateTime::createFromFormat('Y-m-d H:i:s', $to);
        $from = DateTime::createFromFormat('Y-m-d H:i:s', $from);

        return new Response(
            (string) $this->HRService->getAverageHR($type, $from, $to, (int)$patientId)
        );
    }
}