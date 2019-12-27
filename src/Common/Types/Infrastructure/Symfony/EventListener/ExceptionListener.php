<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Symfony\EventListener;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\Exception\ApplicationException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainEntityNotFoundException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\InvalidDomainFormatException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ApiGatewayBadRequestException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ApiGatewayRequestConflictException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ApiGatewayResourceNotFoundException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ApiGatewayServiceUnavailableInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\InfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\InvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\ErrorRestResource;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ExceptionListener
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getException();

        $response = $this->buildResponseForPostKo(new ErrorRestResource([], $exception->getMessage(), get_class($exception)));

        if ($exception instanceof AuthenticationException) {
            $response->setStatusCode(JsonResponse::HTTP_UNAUTHORIZED);
        } else {
            if ($exception instanceof DomainEntityNotFoundException ||
                $exception instanceof ApiGatewayResourceNotFoundException ||
                $exception instanceof NotFoundHttpException) {
                $response->setStatusCode(JsonResponse::HTTP_NOT_FOUND);
            } else {
                if ($exception instanceof InvalidDomainFormatException ||
                    $exception instanceof InvalidArgumentInfrastructureException ||
                    $exception instanceof ApiGatewayBadRequestException) {
                    $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
                } else {
                    if ($exception instanceof ApiGatewayRequestConflictException ||
                        $exception instanceof DomainException) {
                        $response->setStatusCode(JsonResponse::HTTP_CONFLICT);
                    } else {
                        if ($exception instanceof ApiGatewayServiceUnavailableInfrastructureException) {
                            $response->setStatusCode(JsonResponse::HTTP_SERVICE_UNAVAILABLE);
                        } else {
                            if ($exception instanceof InfrastructureException ||
                                $exception instanceof ApplicationException) {
                                $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                            } else {
                                return;
                            }
                        }
                    }
                }
            }
        }

        $this->logger->info($response);

        $event->setResponse($response);
    }

    private function buildResponseForPostKo(ErrorRestResource $errorRestResource): JsonResponse
    {
        $errorRestResourceSerialized = $this->serializer->serialize($errorRestResource, 'json');
        return new JsonResponse(
            $errorRestResourceSerialized,
            JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            [
                'Location' => $errorRestResource->identifier(),
            ],
            true
        );
    }
}
