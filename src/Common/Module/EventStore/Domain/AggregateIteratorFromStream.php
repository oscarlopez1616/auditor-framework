<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\Exception\ThereIsNotEventsForThisAggregateInEventStoreException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use function Lambdish\Phunctional\map;

class AggregateIteratorFromStream
{
    /**
     * @var MetadataEnrichmentField[]
     */
    private $stream;

    /**
     * @param MetadataEnrichmentField[] $stream
     * @return AggregateRoot
     */
    public function aggregateFromStream(array $stream): AggregateRoot
    {
        if(count($stream) === 0){
            throw new ThereIsNotEventsForThisAggregateInEventStoreException();
        }

        $aggregateType = $stream[0]->metadata()->aggregateType();

        /**
         * @var AggregateRoot $aggregate
         */
        $aggregate = new $aggregateType();

        map(
            function (MetadataEnrichmentField $eventStoreItem) use ($aggregate): void{
                $aggregate->apply($eventStoreItem->event());
            }
            ,
            $stream
        );

        return $aggregate;

    }

}
