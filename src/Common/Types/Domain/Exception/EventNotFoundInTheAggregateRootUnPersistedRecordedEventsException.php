<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;

class EventNotFoundInTheAggregateRootUnPersistedRecordedEventsException extends DomainException
{
    /**
     * @var string
     */
    private $errorMessage;

    public function __construct(Id $aggregateRootId, string $eventClassNamespace)
    {
        $this->errorMessage = "Domain event with namespace: \\$eventClassNamespace\\ not found in the non persisted"
            . "recorded events collection inside aggregate root with id: {$aggregateRootId->value()}";

        parent::__construct();
    }


    protected function errorMessage(): string
    {
        return $this->errorMessage;
    }
}
