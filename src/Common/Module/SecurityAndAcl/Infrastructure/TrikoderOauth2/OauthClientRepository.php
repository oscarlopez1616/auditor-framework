<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\TrikoderOauth2;

use AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Oauth\Exception\OauthClientAlreadyExistException;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;

interface OauthClientRepository
{
    /**
     * @param Client $oauthClient
     *
     * @throws OauthClientAlreadyExistException
     */
    public function save(Client $oauthClient): void;
}
