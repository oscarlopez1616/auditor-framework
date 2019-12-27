<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

use AuditorFramework\Common\Types\Domain\Exception\DomainException;
use AuditorFramework\Common\Types\Domain\Uuid;

class AggregateRootNotFoundInEventStoreException extends DomainException
{
    /**
     * @var Uuid
     */
    private $aggregateRootId;

    public function __construct(Uuid $aggregateRootId)
    {
        $this->aggregateRootId = $aggregateRootId;
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return "The AggregateRoot with id: {$this->aggregateRootId->value()} does not exist";
    }
}
