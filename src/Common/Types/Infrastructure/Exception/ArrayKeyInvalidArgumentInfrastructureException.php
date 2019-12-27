<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class ArrayKeyInvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{

    protected function getName(): string
    {
        return 'array key';
    }
}
