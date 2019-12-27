<?php

declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Controller;

use Exception;
use JMS\Serializer\Serializer;
use AuditorFramework\Common\Types\Application\CommandBus;
use AuditorFramework\Common\Types\Application\QueryBus;
use AuditorFramework\Common\Types\Application\UploadCsvKeyValue\UploadCsvKeyValueCommand;
use AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\DataTransformer\IdentifiableDtoResourceToRestResourceDataTransformer;
use AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\DataTransformer\NonIdentifiableDtoResourceToRestResourceDataTransformer;
use AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\CommandRestResource;
use AuditorFramework\Common\Utils\Assertion\InfrastructureAssertion;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api\CsvControllerVoter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CsvController extends Controller
{


    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        IdentifiableDtoResourceToRestResourceDataTransformer $identifiableDtoResourceToApiRestResourceDataTransformer,
        NonIdentifiableDtoResourceToRestResourceDataTransformer $nonIdentifiableDtoResourceToApiRestResourceDataTransformer,
        Serializer $serializer
    ) {
        parent::__construct(
            $commandBus,
            $queryBus,
            $identifiableDtoResourceToApiRestResourceDataTransformer,
            $nonIdentifiableDtoResourceToApiRestResourceDataTransformer,
            $serializer
        );
    }


    protected function namespaces(): array
    {
        return array('common', 'csv');
    }


    /**
     * @Route("/", name="post_csv_key_value", methods={"Post"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function postCsvKeyValue(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted(CsvControllerVoter::POST_CSV_KEY_VALUE);

        $data = json_decode($request->getContent(), true);

        InfrastructureAssertion::keyExists($data, 'id');
        InfrastructureAssertion::keyExists($data, 'data');

        InfrastructureAssertion::isUuid($data['id']);
        InfrastructureAssertion::isString($data['data']);

        $command = new UploadCsvKeyValueCommand(
            $data['id'],
            base64_decode($data['data'])
        );

        $this->commandBus->dispatch($command);

        $commandRestResource = new CommandRestResource($this->namespaces(), $data['id']);

        return $this->buildResponseForPostOk($commandRestResource);
    }
}
