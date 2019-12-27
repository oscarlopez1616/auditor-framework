<?php

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception;

class InvalidFileNameException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'invalid file name';
    }
}
