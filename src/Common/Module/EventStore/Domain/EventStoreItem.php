<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain;

use DateTime;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Metadata;
use DateTimeImmutable;

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
    private $eventName;

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
        string $eventName,
        string $payload,
        Metadata $metadata,
        DateTimeImmutable $createdAt
    ) {
        $this->playHead = $playHead;
        $this->eventId = $eventId;
        $this->eventName = $eventName;
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

    public function eventName(): string
    {
        return $this->eventName;
    }

    public function payload(): string
    {
        return $this->payload;
    }

    public function metadata(): Metadata
    {
        return $this->metadata;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

}
