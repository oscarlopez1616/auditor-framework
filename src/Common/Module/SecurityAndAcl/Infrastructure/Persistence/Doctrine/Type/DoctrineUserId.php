<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Doctrine\Type;

use AuditorFramework\Common\Types\Infrastructure\Persistence\Doctrine\Type\DoctrineId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

class DoctrineUserId extends DoctrineId
{
    public function className(): string
    {
        return UserId::class;
    }
}
