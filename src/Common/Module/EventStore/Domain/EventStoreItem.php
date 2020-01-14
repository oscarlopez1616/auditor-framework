<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain;

use DateTimeImmutable;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Metadata;

class EventStoreItem
{
    /**
     * @var int
     */
    private $playHead;

    /**
     * @var Id
     */
    private $eventId;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var DateTimeImmutable
     */
    private $createdAt;


    public function __construct(
        int $playHead,
        Id $eventId,
        string $payload,
        Metadata $metadata,
        DateTimeImmutable $createdAt
    ) {
        $this->playHead = $playHead;
        $this->eventId = $eventId;
        $this->payload = $payload;
        $this->metadata = $metadata;
        $this->createdAt = $createdAt;
    }

    public function playHead(): int
    {
        return $this->playHead;
    }

    public function eventId(): Id
    {
        return $this->eventId;
    }

    public function event(): Event
    {
        //TODO
    }

    public function payload(): array
    {
        return json_decode($this->payload, true);
    }

    public function metadata(): Metadata
    {
        return $this->metadata;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

}
