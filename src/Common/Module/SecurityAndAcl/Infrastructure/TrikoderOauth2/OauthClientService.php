<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\TrikoderOauth2;

use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\Grant;

class OauthClientService
{
    /**
     * @var OauthClientRepository
     */
    private $oauthClientRepository;

    public function __construct(OauthClientRepository $oauthClientRepository)
    {
        $this->oauthClientRepository = $oauthClientRepository;
    }

    public function create(string $identifier, string $secret): void
    {
        $oauthClient = new Client($identifier, $secret);
        $oauthClient->setGrants(new Grant('password'), new Grant('refresh_token'));

        $this->oauthClientRepository->save($oauthClient);
    }
}
