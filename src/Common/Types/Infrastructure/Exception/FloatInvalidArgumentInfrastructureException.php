<?php

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class FloatInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'float';
    }
}
