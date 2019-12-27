<?php

declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Persistence\Doctrine\Type;

use AuditorFramework\Common\Types\Domain\Uuid;

class DoctrineUuid extends DoctrineInfrastructureId
{
    public function className(): string
    {
        return Uuid::class;
    }
}
