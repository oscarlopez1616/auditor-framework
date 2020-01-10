<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Persistence\EventStore;

use Exception;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\EventStoreIntegration\AggregateRootDecorator;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\EventStoreRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\AggregateRootDuplicateInEventStoreException;
use function Lambdish\Phunctional\map;

class ProophWriteModelRepository implements WriteModelRepository
{
    /**
     * @var EventStoreRepository
     */
    private $eventStoreRepository;

    /**
     * ProophWriteModelRepository constructor.
     * @param EventStoreRepository $eventStoreRepository
     */
    public function __construct(EventStoreRepository $eventStoreRepository)
    {
        $this->eventStoreRepository = $eventStoreRepository;
    }


    /**
     * @var AggregateRoot[] $aggregateRoots
     */
    public function save(array $aggregateRoots): void
    {
        try {
            map(
                function (AggregateRoot $aggregateRoot): void {
                    $this->eventStoreRepository->save($aggregateRoot);
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
        // TODO
    }

    public function findEventsByAggregateIdAndEventName(Id $id, string $eventName): array
    {
        // TODO: Implement findEventsByAggregateIdAndEventName() method.
    }


}
