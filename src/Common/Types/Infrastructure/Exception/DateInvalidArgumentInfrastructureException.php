<?php

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class DateInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'date';
    }
}
