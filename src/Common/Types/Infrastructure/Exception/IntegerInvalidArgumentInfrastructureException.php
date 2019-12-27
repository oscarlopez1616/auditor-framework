<?php

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception;

class IntegerInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{
    protected function getName(): string
    {
        return 'integer';
    }
}
