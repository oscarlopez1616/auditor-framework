<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Oauth\Exception\OauthClientAlreadyExistException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\TrikoderOauth2\OauthClientRepository;
use Trikoder\Bundle\OAuth2Bundle\Manager\ClientManagerInterface;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;

class DoctrineOauthClientRepository implements OauthClientRepository
{
    /**
     * @var ClientManagerInterface
     */
    private $trikoderDoctrineClientManager;

    public function __construct(ClientManagerInterface $trikoderDoctrineClientManager)
    {
        $this->trikoderDoctrineClientManager = $trikoderDoctrineClientManager;
    }

    public function save(Client $oauthClient): void
    {
        try {
            $this->trikoderDoctrineClientManager->save($oauthClient);
        } catch (UniqueConstraintViolationException $e) {
            throw new OauthClientAlreadyExistException();
        }
    }
}
