<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event;

use DateTime;
use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\DateInvalidArgumentInfrastructureException;
use Prooph\EventSourcing\AggregateChanged;

abstract class Event extends AggregateChanged
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    public function __construct(Id $id)
    {
        $this->id = $id;
        try {
            $this->updatedAt = new DateTime();
        } catch (Exception $e) {
            throw new DateInvalidArgumentInfrastructureException('An error has ocurred when creating a DateTime');
        }
        parent::__construct($id->value(), $this->serialize());
    }

    /**
     * @return Id
     */
    public function id(): Id
    {
        return $this->id;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function unserialize(): void
    {
        $specializedIdClass = $this->getIdClass();
        $this->id = new $specializedIdClass($this->aggregateId());
        $this->internalUnSerialize();
        $this->updatedAt = DateTime::createFromFormat(
            DateTime::ATOM,
            $this->payload()['updated_at']
        );
    }

    public function serialize(): array
    {
        return array_merge($this->internalSerialize(), ['updated_at' => $this->updatedAt->format(DateTime::ATOM)]);
    }

    abstract protected function getIdClass(): string;

    abstract protected function internalUnSerialize(): void;

    abstract public function internalSerialize(): array;

    public function version(): int
    {
        $this->unserialize();
        return $this->metadata['_aggregate_version'];
    }

    public function changeVersion(int $version)
    {
        $this->setVersion($version);
    }
}
