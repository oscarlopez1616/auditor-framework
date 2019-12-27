<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Service;

use DateTime;
use DateTimeImmutable;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;

class NullableObjectService
{
    public static function equalsValueObject(?ValueObject $vo, ?ValueObject $anotherVo): bool
    {
        if ($vo === null && $anotherVo === null) {
            return true;
        }

        if ($vo === null || $anotherVo === null) {
            return false;
        }

        return $vo->equals($anotherVo);
    }

    public static function equalsString(?string $string, ?string $anotherString): bool
    {
        if ($string === null && $anotherString === null) {
            return true;
        }

        if ($string === null || $anotherString === null) {
            return false;
        }

        return $string === $anotherString;
    }

    public static function equalsBool(?bool $bool, ?bool $anotherBool): bool
    {
        if ($bool === null && $anotherBool === null) {
            return true;
        }

        if ($bool === null || $anotherBool === null) {
            return false;
        }

        return $bool === $anotherBool;
    }

    public static function equalsDateTime(?DateTime $dateTime, ?DateTime $anotherDatetime): bool
    {
        if ($dateTime === null && $anotherDatetime === null) {
            return true;
        }

        if ($dateTime === null || $anotherDatetime === null) {
            return false;
        }

        return $dateTime === $anotherDatetime;
    }

    public static function equalsDateTimeImmutable(?DateTimeImmutable $dateTimeImmutable, ?DateTimeImmutable $anotherDateTimeImmutable): bool
    {
        if ($dateTimeImmutable === null && $anotherDateTimeImmutable === null) {
            return true;
        }

        if ($dateTimeImmutable === null || $anotherDateTimeImmutable === null) {
            return false;
        }

        return $dateTimeImmutable === $anotherDateTimeImmutable;
    }
}
