<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Exception;

use AuditorFramework\Common\Types\Domain\Exception\DomainException;

class PasswordRecoveryAlreadyExistException extends DomainException
{
    protected function errorMessage(): string
    {
        return 'This PasswordRecovery already exist';
    }
}
