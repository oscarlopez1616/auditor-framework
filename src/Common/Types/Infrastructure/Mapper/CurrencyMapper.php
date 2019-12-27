<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Mapper;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\CurrencyISO4217InvalidArgumentInfrastructureException;

class CurrencyMapper
{
    public static function fromISO4217NumberToISOCode(int $isoNumber): string
    {
        $isoCurrencies = new ISOCurrencies();
        /** @var Currency $isoCurrency */
        foreach ($isoCurrencies->getIterator() as $isoCurrency) {
            if ($isoCurrencies->numericCodeFor($isoCurrency) === $isoNumber) {
                return $isoCurrency->getCode();
            }
        }

        throw new CurrencyISO4217InvalidArgumentInfrastructureException($isoNumber);
    }
}
