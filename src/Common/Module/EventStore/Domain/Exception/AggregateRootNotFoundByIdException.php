<?php

namespace WebCamScrapper\Module\CamLandingGenerator\Domain\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainEntityNotFoundByIdException;

class AggregateRootNotFoundByIdException extends DomainEntityNotFoundByIdException
{
    protected function entityNamespace(): string
    {
        return AggregateRoot::class;
    }
}
