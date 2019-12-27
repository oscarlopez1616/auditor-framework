<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Doctrine\Type;

use AuditorFramework\Common\Types\Infrastructure\Persistence\Doctrine\Type\DoctrineId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;

class DoctrinePasswordRecoveryId extends DoctrineId
{
    public function className(): string
    {
        return PasswordRecoveryId::class;
    }
}
