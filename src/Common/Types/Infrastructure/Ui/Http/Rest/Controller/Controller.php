<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Controller;

use JMS\Serializer\Context;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\DataTransformer\IdentifiableDtoResourceToRestResourceDataTransformer;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\DataTransformer\NonIdentifiableDtoResourceToRestResourceDataTransformer;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\CommandRestResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\RestResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\RestResourceCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class Controller extends AbstractController
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @var QueryBus
     */
    protected $queryBus;

    /**
     * @var IdentifiableDtoResourceToRestResourceDataTransformer
     */
    protected $identifiableDtoResourceToApiRestResourceDataTransformer;

    /**
     * @var NonIdentifiableDtoResourceToRestResourceDataTransformer
     */
    protected $nonIdentifiableDtoResourceToApiRestResourceDataTransformer;

    /**
     * @var Serializer
     */
    protected $serializer;

    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        IdentifiableDtoResourceToRestResourceDataTransformer $identifiableDtoResourceToApiRestResourceDataTransformer,
        NonIdentifiableDtoResourceToRestResourceDataTransformer $nonIdentifiableDtoResourceToApiRestResourceDataTransformer,
        Serializer $serializer
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->identifiableDtoResourceToApiRestResourceDataTransformer = $identifiableDtoResourceToApiRestResourceDataTransformer;
        $this->nonIdentifiableDtoResourceToApiRestResourceDataTransformer = $nonIdentifiableDtoResourceToApiRestResourceDataTransformer;
        $this->serializer = $serializer;
    }

    /**
     * In order to generate a correct URN for the resource identifier, at least a namespace should be
     * provided. The namespaces provided would be appended to the top most namespace: auditor_framework. So for example
     * if the following namespaces were provided.
     *
     *      return ['user', 'login']
     *
     * The following resource identifier could be generated
     *
     *      urn:auditor_framework:user:login:12345
     *
     * @return array
     */
    abstract protected function namespaces(): array;

    public function buildResponseForGetRestOk(RestResource $restResource): JsonResponse
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return new JsonResponse(
            $this->serializer->serialize($restResource, 'json', $context),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    public function buildResponseForGetRestKoNotFound(): JsonResponse
    {
        return new JsonResponse(
            '{"status":"ko"}',
            JsonResponse::HTTP_NOT_FOUND,
            [],
            true
        );
    }

    public function buildResponseForGetRestCollectionOk(RestResourceCollection $restResourceCollection
    ): JsonResponse {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return new JsonResponse(
            $this->serializer->serialize($restResourceCollection, 'json', $context),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    public function buildResponseForPostOk(CommandRestResource $commandRestResource): JsonResponse
    {
        $commandRestResourceSerialized = $this->serializer
            ->serialize($commandRestResource,'json', $this->buildSerializationContextWithGroup('ok'));

        return new JsonResponse(
            $commandRestResourceSerialized,
            JsonResponse::HTTP_CREATED,
            [
                'Location' => $commandRestResource->identifier(),
            ],
            true
        );
    }

    public function buildResponseForPostKo(CommandRestResource $commandRestResource): JsonResponse
    {
        $commandRestResourceSerialized = $this->serializer
            ->serialize($commandRestResource,'json', $this->buildSerializationContextWithGroup('ko'));

        return new JsonResponse(
            $commandRestResourceSerialized,
            JsonResponse::HTTP_BAD_REQUEST,
            [
                'Location' => $commandRestResource->identifier(),
            ],
            true
        );
    }

    public function buildResponseForPatchOk(CommandRestResource $commandRestResource): JsonResponse
    {
        $commandRestResourceSerialized = $this->serializer
            ->serialize($commandRestResource,'json', $this->buildSerializationContextWithGroup('ok'));

        return new JsonResponse(
            $commandRestResourceSerialized,
            JsonResponse::HTTP_NO_CONTENT,
            [
                'Location' => $commandRestResource->identifier(),
            ],
            true
        );
    }

    /**
     * @param string $group
     *
     * @return SerializationContext|Context
     */
    private function buildSerializationContextWithGroup(string $group): SerializationContext
    {
        return SerializationContext::create()->setGroups([$group]);
    }
}
