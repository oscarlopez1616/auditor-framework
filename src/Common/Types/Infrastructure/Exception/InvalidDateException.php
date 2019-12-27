<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

use AuditorFramework\Common\Types\Domain\Exception\InvalidDomainFormatException;

class InvalidDateException extends InvalidDomainFormatException
{

    protected function getName(): string
    {
        return 'date';
    }
}
