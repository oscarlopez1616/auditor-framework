<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Persistence\Doctrine\Type;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;

class DoctrineUuid extends DoctrineInfrastructureId
{
    public function className(): string
    {
        return Uuid::class;
    }
}
