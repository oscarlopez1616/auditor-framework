<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use ReflectionClass;
use ReflectionException;

abstract class DomainEntityNotFoundByIdException extends DomainEntityNotFoundException
{
    /**
     * @var Id
     */
    private $entityId;

    public function __construct(Id $entityId = null)
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
        return sprintf('\%s\ with id \%s\ not found', $this->entityName(), $this->entityId());
    }

    abstract protected function entityNamespace(): string;

    protected function entityId(): ?Id
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
