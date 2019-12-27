<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController
{

    /**
     *
     * @Route("/ping", name="get_ping", methods={"GET"})
     *
     *
     * @return JsonResponse
     */
    public function getPing(): JsonResponse
    {
        return new JsonResponse();
    }
}
