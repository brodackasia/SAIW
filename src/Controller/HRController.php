<?php

declare(strict_types=1);

namespace App\Controller;

use App\CurrentHRQuery\CurrentHRFactory\CurrentHrQueryFactory;
use App\Query\Factory\HrQueryFactory;
use App\Service\HRService;
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

    //CHART
    #[Route('/chart/{type}', name: 'hr.chart', methods: ['GET'])]
    public function chartData(Request $request, string $type): Response
    {
        $query = HrQueryFactory::createFromQueryParameters(
            $request->query->all()
        );

        $query->setType($type);

        return new JsonResponse(
            $this->HRService->getChartData($query)
        );
    }

    //CURRENT
    #[Route('/current/{type}', name: 'hr.current', methods: ['GET'])]
    public function currentHr(Request $request, string $type): Response
    {
        $query = CurrentHrQueryFactory::createFromCurrentQueryParameters(
            $request->query->all()
        );

        $query->setType($type);

        return new JsonResponse(
            $this->HRService->getCurrentHR($query)
        );
    }

    //MINIMUM
    #[Route('/minimum/{type}', name: 'hr.minimum', methods: ['GET'])]
    public function minimumHr(Request $request, string $type): Response
    {
        $query = HrQueryFactory::createFromQueryParameters(
            $request->query->all()
        );

        $query->setType($type);

        return new JsonResponse(
            $this->HRService->getMinimumHR($query)
        );
    }

    //MAXIMUM
    #[Route('/maximum/{type}', name: 'hr.maximum', methods: ['GET'])]
    public function maximumHr(Request $request, string $type): Response
    {
        $query = HrQueryFactory::createFromQueryParameters(
            $request->query->all()
        );

        $query->setType($type);

        return new JsonResponse(
            $this->HRService->getMaximumHR($query)
        );
    }

    //AVERAGE
    #[Route('/average/{type}', name: 'hr.average', methods: ['GET'])]
    public function averageHr(Request $request, string $type): Response
    {
        $query = HrQueryFactory::createFromQueryParameters(
            $request->query->all()
        );

        $query->setType($type);

        return new JsonResponse(
            $this->HRService->getAverageHR($query)
        );
    }
}