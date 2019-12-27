<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Utils\Assertion;

use Assert\Assertion as BeberleiAssertion;

abstract class Assertion
{
    protected static function notEmpty($value): void
    {
        BeberleiAssertion::notEmpty($value);
    }

    protected static function notEmptyString($value): void
    {
        self::notEmpty($value);
        self::isString($value);
    }

    protected static function isString($string): void
    {
        BeberleiAssertion::string($string);
    }

    protected static function isUuid($value): void
    {
        BeberleiAssertion::uuid($value);
    }

    protected static function isPercentage($value): void
    {
        BeberleiAssertion::float($value);
        BeberleiAssertion::greaterOrEqualThan($value, 0);
        BeberleiAssertion::lessOrEqualThan($value, 1);
    }

    protected static function isIntegerPositive($value): void
    {
        BeberleiAssertion::integer($value);
        BeberleiAssertion::greaterThan($value, 0);
    }
}
