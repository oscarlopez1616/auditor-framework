<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;

class PasswordRecoveryAlreadyExistException extends DomainException
{
    protected function errorMessage(): string
    {
        return 'This PasswordRecovery already exist';
    }
}
