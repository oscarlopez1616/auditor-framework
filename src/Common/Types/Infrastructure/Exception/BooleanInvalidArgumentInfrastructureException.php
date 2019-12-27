<?php

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception;

class BooleanInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'boolean';
    }
}
