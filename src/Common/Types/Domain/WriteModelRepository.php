<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;

interface WriteModelRepository
{
    /**
     * @param AggregateRoot[] $aggregateRoots
     */
    public function save(array $aggregateRoots): void;

    public function findAggregateByAggregateId(Id $id, string $aggregateRootClass): AggregateRoot;

    /**
     * @param Id $id
     * @param string $eventName
     * @return Event[]
     */
    public function findEventsByAggregateIdAndEventName(Id $id, string $eventName): array;
}
