<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception;

class AggregateRootAlreadyRegisteredInEntityException extends DomainException
{
    /**
     * @var string
     */
    private $aggregateClass;

    /**
     * @var string
     */
    private $entityClass;

    public function __construct(string $aggregateClass, string $entityClass)
    {
        $this->aggregateClass = $aggregateClass;
        $this->entityClass = $entityClass;
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('The AggregateRoot \%s\ is already registered in entity \%s\ ', $this->aggregateClass, $this->entityClass);
    }
}
