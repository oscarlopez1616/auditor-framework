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
     * @var array
     */
    private $metadataEnrichmentFields;

    /**
     * Metadata constructor.
     * @param Id $aggregateId
     * @param string $aggregateType
     */
    public function __construct(Id $aggregateId, string $aggregateType)
    {
        $this->aggregateId = $aggregateId;
        $this->aggregateType = $aggregateType;
        $this->metadataEnrichmentFields = [];
    }

    public function aggregateId(): Id
    {
        return $this->aggregateId;
    }

    public function aggregateType(): string
    {
        return $this->aggregateType;
    }

    public function metadataEnrichmentFields(): array
    {
        return $this->metadataEnrichmentFields;
    }

    public function addMetadataField(string $key, string $value):void
    {
        $this->metadataEnrichmentFields = [$key => $value];
    }

    public function deleteMetadataFieldByKey(string $key):void
    {
        unset($this->metadataEnrichmentFields[$key]);
    }

}
