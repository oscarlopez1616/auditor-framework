<?php

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class JsonStringInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'jsonString';
    }
}
