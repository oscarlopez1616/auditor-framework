<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception;

use AuditorFramework\Common\Types\Domain\Exception\DomainEntityNotFoundByIdException;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;

class UserNotFoundByIdException extends DomainEntityNotFoundByIdException
{
    protected function entityNamespace(): string
    {
        return User::class;
    }
}
