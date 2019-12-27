<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\ApiGateway;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use JMS\Serializer\Serializer;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ApiGatewayBadRequestException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ApiGatewayInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ApiGatewayRequestConflictException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ApiGatewayResourceNotFoundException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Client\Oauth2ClientBuilder;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Client\Oauth2ClientDirector;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Controller\Controller;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\DataTransformer\IdentifiableDtoResourceToRestResourceDataTransformer;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\DataTransformer\NonIdentifiableDtoResourceToRestResourceDataTransformer;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

abstract class ApiGatewayController extends Controller
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        IdentifiableDtoResourceToRestResourceDataTransformer $identifiableDtoResourceToApiRestResourceDataTransformer,
        NonIdentifiableDtoResourceToRestResourceDataTransformer $nonIdentifiableDtoResourceToApiRestResourceDataTransformer,
        Serializer $serializer,
        Oauth2ClientDirector $clientDirector,
        Oauth2ClientBuilder $clientBuilder
    ) {
        parent::__construct(
            $commandBus,
            $queryBus,
            $identifiableDtoResourceToApiRestResourceDataTransformer,
            $nonIdentifiableDtoResourceToApiRestResourceDataTransformer,
            $serializer
        );

        $clientDirector->createClient($clientBuilder);
        $this->httpClient = $clientBuilder->getClient();
    }

    protected function namespaces(): array
    {
        return ['api_gateway'];
    }

    protected function generateRelativeUri(string $routePath, array $queryStringParams = []): string
    {
        $relativeUri = ltrim($routePath, '/');

        $isFirstElement = true;

        foreach ($queryStringParams as $routeParamName => $routeParamValue) {
            $paramSeparator = '&';
            if ($isFirstElement) {
                $paramSeparator = '?';
            }

            $relativeUri.= "{$paramSeparator}{$routeParamName}={$routeParamValue}";
        }

        return $relativeUri;
    }

    protected function buildPatchBody(string $id, string $patchOperation, array $bodyParams): array
    {
        return (['id' => $id, 'op' => $patchOperation] + $bodyParams);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $body
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function callToEndpoint(string $method, string $url, array $body = []): ResponseInterface
    {
        $options = $body ? [RequestOptions::JSON => $body] : [];

        $options['auth'] = 'oauth';
        $options['headers'] = ['Accept' => 'application/json'];
        return $this->httpClient->request($method, $url, $options);
    }

    protected function processRequestException(RequestException $e): void
    {
        $responseError = $e->getResponse()->getBody()->getContents();

        switch ($e->getResponse()->getStatusCode()) {
            case Response::HTTP_UNAUTHORIZED:
                throw new AuthenticationException($responseError);
                break;
            case Response::HTTP_NOT_FOUND:
                throw new ApiGatewayResourceNotFoundException($responseError);
                break;
            case Response::HTTP_BAD_REQUEST:
                throw new ApiGatewayBadRequestException($responseError);
                break;
            case Response::HTTP_CONFLICT:
                throw new ApiGatewayRequestConflictException($responseError);
                break;
            case Response::HTTP_INTERNAL_SERVER_ERROR:
                throw new ApiGatewayInfrastructureException($responseError);
            default:
                throw new ApiGatewayInfrastructureException($responseError);
        }
    }
}
