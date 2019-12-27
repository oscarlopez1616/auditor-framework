<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;

class AggregateRootDuplicateInEventStoreException extends DomainException
{
    protected function errorMessage(): string
    {
        return 'This AggregateRoot already exist in the Event Store';
    }
}
