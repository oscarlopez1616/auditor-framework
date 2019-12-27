<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\InvalidDomainFormatException;

class InvalidDateException extends InvalidDomainFormatException
{

    protected function getName(): string
    {
        return 'date';
    }
}
