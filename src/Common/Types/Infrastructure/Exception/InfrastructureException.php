<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception;

use DomainException as SPLDomainException;

abstract class InfrastructureException extends SPLDomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    abstract protected function errorMessage(): string;
}
