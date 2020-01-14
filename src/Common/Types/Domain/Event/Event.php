<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event;

use DateTime;
use Exception;
use ReflectionClass;
use ReflectionException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\EventStoreItem;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\MetadataEnrichmentField;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Metadata;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\DateInvalidArgumentInfrastructureException;

abstract class Event
{
    /**
     * @var Metadata
     */
    protected $metadata;

    /**
     * @var int
     */
    protected $version;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * Event constructor.
     * @param Id $id
     * @param MetadataEnrichmentField[] $metadataEnrichmentFields
     * @param int $version
     */
    public function __construct(
        Id $id,
        array $metadataEnrichmentFields = [],
        int $version = 0
    ) {
        $this->metadata = new Metadata(
            $id,
            get_parent_class($this),
            $metadataEnrichmentFields
        );

        $this->version = $version;

        try {
            $this->createdAt = new DateTime();
        } catch (Exception $e) {
            throw new DateInvalidArgumentInfrastructureException('An error has ocurred when creating a DateTime');
        }
    }

    /**
     * @param EventStoreItem $eventStoreItem
     * @return static
     * @throws ReflectionException
     */
    public static function fromEventStoreItem(EventStoreItem $eventStoreItem): self
    {
        $eventType = $eventStoreItem->metadata()->aggregateType();

        /**
         * @var Event $event
         */
        $event = new ReflectionClass($eventType());

        $event->unserializePayload($eventStoreItem->payload());
        return $event;
    }

    public function metadata(): Metadata
    {
        return $this->metadata;
    }

    abstract protected function getIdClass(): string;

    public function version(): int
    {
        return $this->version;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function serializePayload(): array
    {
        return $this->internalSerializePayload();
    }

    abstract public function internalSerializePayload(): array;

    public function unserializePayload(array $payload): void
    {
        $this->internalUnSerializePayload($payload);
    }

    abstract protected function internalUnSerializePayload(array $payload): void;

}
