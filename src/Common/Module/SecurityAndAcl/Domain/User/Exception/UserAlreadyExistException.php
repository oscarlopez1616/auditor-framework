<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception;

use AuditorFramework\Common\Types\Domain\Exception\DomainException;

class UserAlreadyExistException extends DomainException
{
    protected function errorMessage(): string
    {
        return 'This User already exist';
    }
}
