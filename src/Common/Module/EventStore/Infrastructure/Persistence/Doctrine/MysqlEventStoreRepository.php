<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use TheCodeFighters\Bundle\AuditorFramework\Common\EventStore\Infrastructure\Exception\EventStoreItemDuplicateInEventStoreException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\EventStoreItem;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\EventStoreRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use function Lambdish\Phunctional\map;

class MysqlEventStoreRepository implements EventStoreRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        try {
            map(
                function () use ($aggregateRoot):void{
                    $this->entityManager->persist($aggregateRoot);
                },
                $this->eventStoreItemsFromAggregateRoot()
            );
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new EventStoreItemDuplicateInEventStoreException();
        }
    }

    /**
     * @param AggregateRoot $aggregateRoot
     * @return EventStoreItem[]
     */
    private function eventStoreItemsFromAggregateRoot(AggregateRoot $aggregateRoot): array
    {
        return map(
            function (Event $event) use ($aggregateRoot): EventStoreItem
            {
                new EventStoreItem(
                    $aggregateRoot->playHead(),
                    $aggregateRoot->id(),
                    get_class($event),
                    json_encode($event->serialize()),
                    $aggregateRoot->metadata(),
                    $aggregateRoot->updatedAt()
                );
            }
            ,
            $aggregateRoot->unPersistedRecordedEvents()
        );
    }

}
