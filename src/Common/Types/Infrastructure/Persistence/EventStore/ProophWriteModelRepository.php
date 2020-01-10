<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Persistence\EventStore;

use Exception;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\EventStoreIntegration\AggregateRootDecorator;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\AggregateRootDuplicateInEventStoreException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\AggregateRootNotFoundInEventStoreException;
use function Lambdish\Phunctional\map;

class ProophWriteModelRepository extends AggregateRepository implements WriteModelRepository
{
    /**
     * @var AggregateRoot[] $aggregateRoots
     */
    public function save(array $aggregateRoots): void
    {
        try {
            map(
                function (AggregateRoot $aggregateRoot): void {
                    $this->aggregateType = AggregateType::fromAggregateRoot($aggregateRoot);
                    $this->saveAggregateRoot($aggregateRoot);
                    $aggregateRoot->flushUnPersistedRecordedEvents();
                },
                $aggregateRoots
            );

        } catch (Exception $e) {
            throw new AggregateRootDuplicateInEventStoreException();
        }
    }

    public function findAggregateByAggregateId(Id $id, string $aggregateRootClass): AggregateRoot
    {
        $this->aggregateType = AggregateType::fromAggregateRootClass($aggregateRootClass);
        $aggregateRoot = $this->getAggregateRoot('12836da8-0c46-491b-a1b2-85188f0c8b7a');
        if(is_null($aggregateRoot)){
            throw new AggregateRootNotFoundInEventStoreException($id);
        }
        return $aggregateRoot;
    }

    /**
     * @param Id $id
     * @param string $eventName
     * @return Event[]
     */
    public function findEventsByAggregateIdAndEventName(Id $id, string $eventName): array
    {
        try {
            /** @var AggregateRoot $aggregateRoot */
            $aggregateRoot = $this->getAggregateRoot($id->value());
            /** @var AggregateRootDecorator $aggregateRootDecorator */
            $aggregateRootDecorator = $this->aggregateTranslator->getAggregateRootDecorator();
            /** @var AggregateChanged[] $recordedEvents */
            $recordedEvents = $aggregateRootDecorator->extractRecordedEvents($aggregateRoot);
            foreach ($recordedEvents as $recordedEvent) {
                var_dump($recordedEvent);
                die();
            }
        } catch (Exception $e) {
            throw new AggregateRootNotFoundInEventStoreException($id);
        }
    }
}
