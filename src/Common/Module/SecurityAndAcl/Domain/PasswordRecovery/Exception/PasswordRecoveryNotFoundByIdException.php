<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Exception;

use AuditorFramework\Common\Types\Domain\Exception\DomainEntityNotFoundByIdException;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecovery;

class PasswordRecoveryNotFoundByIdException extends DomainEntityNotFoundByIdException
{
    protected function entityNamespace(): string
    {
        return PasswordRecovery::class;
    }
}
