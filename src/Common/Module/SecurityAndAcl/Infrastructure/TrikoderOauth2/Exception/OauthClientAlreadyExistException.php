<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Oauth\Exception;

use AuditorFramework\Common\Types\Infrastructure\Exception\InfrastructureException;

class OauthClientAlreadyExistException extends InfrastructureException
{
    protected function errorMessage(): string
    {
        return 'This OauthClient already exist';
    }
}
