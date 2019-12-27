<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class StringInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'string';
    }
}
