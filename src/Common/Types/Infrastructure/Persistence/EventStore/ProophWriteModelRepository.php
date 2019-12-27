<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Persistence\EventStore;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\AggregateRootDuplicateInEventStoreException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\AggregateRootNotFoundInEventStoreException;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\EventStoreIntegration\AggregateRootDecorator;
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

    /**
     * @param Uuid $uuid
     * @param string $eventName
     * @return Event[]
     */
    public function findEventByAggregateIdAndEventName(Uuid $uuid, string $eventName): array
    {
        try {
            /** @var AggregateRoot $aggregateRoot */
            $aggregateRoot = $this->getAggregateRoot($uuid->value());
            /** @var AggregateRootDecorator $aggregateRootDecorator */
            $aggregateRootDecorator = $this->aggregateTranslator->getAggregateRootDecorator();
            /** @var AggregateChanged[] $recordedEvents */
            $recordedEvents = $aggregateRootDecorator->extractRecordedEvents($aggregateRoot);
            foreach ($recordedEvents as $recordedEvent) {
                var_dump($recordedEvent);
                die();
            }
        } catch (Exception $e) {
            throw new AggregateRootNotFoundInEventStoreException($uuid);
        }
    }
}
