<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;

class ThereIsNotEventsForThisAggregateInEventStoreException extends DomainException
{
    protected function errorMessage(): string
    {
        return 'This Event already exist in the Event Store';
    }
}
