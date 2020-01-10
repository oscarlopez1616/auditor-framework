<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;

interface EventStoreRepository
{
    public function save(AggregateRoot $aggregateRoot): void;
}
