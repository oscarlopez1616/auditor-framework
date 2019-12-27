<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application;

use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;

abstract class TransactionAwareApplicationService implements ApplicationService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var WriteModelRepository
     */
    private $writeModelRepository;

    public function __construct(EntityManagerInterface $entityManager, WriteModelRepository $writeModelRepository)
    {
        $this->entityManager = $entityManager;
        $this->writeModelRepository = $writeModelRepository;
    }

    protected function beginTransaction(): void
    {
        $this->entityManager->getConnection()->beginTransaction();
    }

    /**
     * @throws ConnectionException
     */
    protected function commit(): void
    {
        $this->entityManager->getConnection()->commit();
    }

    /**
     * @throws ConnectionException
     */
    protected function rollBack(): void
    {
        $this->entityManager->getConnection()->rollBack();
    }

    protected function saveInWriteModel(array $aggregateRoots): void
    {
        $this->writeModelRepository->save($aggregateRoots);
    }

    public function writeModelRepository(): WriteModelRepository
    {
        return $this->writeModelRepository;
    }
}
