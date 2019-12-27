<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;

class UserAlreadyExistException extends DomainException
{
    protected function errorMessage(): string
    {
        return 'This User already exist';
    }
}
