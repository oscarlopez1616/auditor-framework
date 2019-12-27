<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Domain;

use AuditorFramework\Common\Types\Domain\AggregateRoot;
use AuditorFramework\Common\Types\Domain\Event\Event;
use AuditorFramework\Common\Types\Domain\Uuid;

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
