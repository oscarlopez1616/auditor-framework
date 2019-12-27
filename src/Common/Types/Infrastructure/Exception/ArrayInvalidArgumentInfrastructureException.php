<?php

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class ArrayInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'array';
    }
}
