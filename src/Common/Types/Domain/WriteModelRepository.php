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

    /**
     * @param Uuid $uuid
     * @param string $eventName
     * @return Event[]
     */
    public function findEventByAggregateIdAndEventName(Uuid $uuid, string $eventName): array;
}
