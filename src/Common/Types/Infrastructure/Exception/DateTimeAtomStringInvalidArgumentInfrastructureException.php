<?php

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class DateTimeAtomStringInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'dateAtom';
    }
}
