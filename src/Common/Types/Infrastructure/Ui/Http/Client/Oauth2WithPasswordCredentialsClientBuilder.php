<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\GrantType\PasswordCredentials;
use kamermans\OAuth2\OAuth2Middleware;

class Oauth2WithPasswordCredentialsClientBuilder implements Oauth2ClientBuilder
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var ClientInterface
     */
    private $reAuthClient;

    /**
     * @var HandlerStack
     */
    private $handlerStack;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $reAuthUrl;

    /**
     * @var array
     */
    private $reAuthConfig;

    public function __construct(string $baseUrl, string $reAuthUrl, array $reAuthConfig)
    {
        $this->baseUrl = $baseUrl;
        $this->reAuthUrl = $reAuthUrl;
        $this->reAuthConfig = $reAuthConfig;
    }

    public function createReAuthClient(): void
    {
        $this->reAuthClient = new Client(['base_uri' => $this->reAuthUrl]);
    }

    public function configureGrantType(): void
    {
        $grantType = new PasswordCredentials($this->reAuthClient, $this->reAuthConfig);
        $oauth = new OAuth2Middleware($grantType);

        $handlerStack = HandlerStack::create();
        $handlerStack->push($oauth);

        $this->handlerStack = $handlerStack;
    }

    public function createClient(): void
    {
        $this->client = new Client(
            [
                'handler' => $this->handlerStack,
                'auth' => 'oauth',
                'base_uri' => $this->baseUrl,
            ]
        );
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }
}
