<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Infrastructure\Persistence\Doctrine;

use DateTimeImmutable;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use TheCodeFighters\Bundle\AuditorFramework\Common\EventStore\Infrastructure\Exception\EventStoreItemDuplicateInEventStoreException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\MetadataEnrichmentField;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Domain\EventStoreRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use WebCamScrapper\Module\CamLandingGenerator\Domain\Affiliate;
use WebCamScrapper\Module\CamLandingGenerator\Domain\Exception\AggregateRootNotFoundByIdException;
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
                function (MetadataEnrichmentField $eventStoreItem) :void{
                    $this->entityManager->persist($eventStoreItem);
                },
                $this->eventStoreItemsFromAggregateRoot($aggregateRoot)
            );
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new EventStoreItemDuplicateInEventStoreException();
        }
    }

    public function findAggregateByAggregateId(Id $aggregateRootId): AggregateRoot
    {
        $aggregateRoot = $this->entityManager->getRepository(MetadataEnrichmentField::class)->findOneBy(array('id' => $aggregateRootId));
        if (!$aggregateRoot instanceof AggregateRoot) {
            throw new AggregateRootNotFoundByIdException($aggregateRootId);
        }
        return $aggregateRoot;
    }

    /**
     * @param AggregateRoot $aggregateRoot
     * @return MetadataEnrichmentField[]
     */
    private function eventStoreItemsFromAggregateRoot(AggregateRoot $aggregateRoot): array
    {
        return map(
            function (Event $event) use ($aggregateRoot): MetadataEnrichmentField
            {
                return new MetadataEnrichmentField(
                    $aggregateRoot->playHead(),
                    $aggregateRoot->id(),
                    get_class($event),
                    json_encode($event->serializePayload()),
                    $aggregateRoot->metadata(),
                    DateTimeImmutable::createFromMutable($aggregateRoot->updatedAt())
                );
            }
            ,
            $aggregateRoot->unPersistedRecordedEvents()
        );
    }

}
