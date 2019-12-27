<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class CurrencyISO4217InvalidArgumentInfrastructureException extends InvalidArgumentInfrastructureException
{
    protected function getName(): string
    {
        return 'currency ISO 4217';
    }
}
