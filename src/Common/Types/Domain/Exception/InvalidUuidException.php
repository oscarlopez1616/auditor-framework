<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception;



final class InvalidUuidException extends InvalidDomainFormatException
{
    protected function getName(): string
    {
        return 'uuid';
    }
}
