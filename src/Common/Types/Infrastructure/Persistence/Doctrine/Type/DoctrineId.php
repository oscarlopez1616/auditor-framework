<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Persistence\Doctrine\Type;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;

class DoctrineId extends DoctrineInfrastructureId
{
    public function className(): string
    {
        return Id::class;
    }
}
