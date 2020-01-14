<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

class Metadata
{
    /**
     * @var Id
     */
    private $aggregateId;

    /**
     * @var string
     */
    private $aggregateType;

    /**
     * @var string
     */
    private $eventType;

    /**
     * @var array
     */
    private $metadataEnrichmentFields;

    /**
     * Metadata constructor.
     * @param Id $aggregateId
     * @param string $aggregateType
     * @param string $eventType
     * @param array $metadataEnrichmentFields
     */
    public function __construct(
        Id $aggregateId,
        string $aggregateType,
        string $eventType,
        Array $metadataEnrichmentFields = []
    ) {
        $this->aggregateId = $aggregateId;
        $this->aggregateType = $aggregateType;
        $this->eventType = $eventType;
        $this->metadataEnrichmentFields = $metadataEnrichmentFields;
    }

    public function aggregateId(): Id
    {
        return $this->aggregateId;
    }

    public function aggregateType(): string
    {
        return $this->aggregateType;
    }

    public function eventType(): string
    {
        return $this->eventType;
    }

    public function metadataEnrichmentFields(): array
    {
        return $this->metadataEnrichmentFields;
    }

    public function addMetadataField(string $key, string $value): void
    {
        $this->metadataEnrichmentFields = [$key => $value];
    }

    public function deleteMetadataFieldByKey(string $key): void
    {
        unset($this->metadataEnrichmentFields[$key]);
    }

    public function serialize(): array
    {
        return [
            'aggregate_id' => $this->aggregateId(),
            'aggregate_type' => $this->aggregateType()
        ];
    }

    public function unSerialize(array $payload): void
    {
        $this->aggregateId = $this->serialize()['aggregate_id'];
        $this->aggregateType = $this->serialize()['aggregate_type'];
    }

}
