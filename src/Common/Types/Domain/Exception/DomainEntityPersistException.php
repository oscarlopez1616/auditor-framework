<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;
use ReflectionClass;
use ReflectionException;

abstract class DomainEntityPersistException extends DomainException
{
    /**
     * @var Uuid
     */
    private $entityId;

    public function __construct(Uuid $entityId)
    {
        $this->entityId = $entityId;
        parent::__construct();
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    protected function errorMessage(): string
    {
        return sprintf('\%s\ with id \%s\ error on persist', $this->entityName(), $this->entityId());
    }

    abstract protected function entityNamespace(): string;

    protected function entityId(): Uuid
    {
        return $this->entityId;
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    private function entityName(): string
    {
        return (new ReflectionClass($this->entityNamespace()))->getShortName();
    }
}
