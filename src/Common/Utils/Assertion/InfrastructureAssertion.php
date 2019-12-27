<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Utils\Assertion;

use Assert\Assertion as BeberleiAssertion;
use Assert\AssertionFailedException;
use DateTime;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ArrayInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\ArrayKeyInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\BooleanInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\DateInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\DateTimeAtomStringInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\FloatInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\IntegerInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\JsonStringInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\StringInvalidArgumentInfrastructureException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\UuidInvalidArgumentInfrastructureException;

class InfrastructureAssertion extends Assertion
{
    public static function isValidDateTimeAtomString(string $string): void
    {
        try {
            BeberleiAssertion::date($string, DateTime::ATOM);
        } catch (AssertionFailedException $e) {
            throw new DateTimeAtomStringInvalidArgumentInfrastructureException($string);
        }
    }

    public static function isValidJsonString(string $string): void
    {
        try {
            BeberleiAssertion::isJsonString($string);

        } catch (AssertionFailedException $e) {
            throw new JsonStringInvalidArgumentInfrastructureException($string);
        }
    }

    public static function notEmptyString($value): void
    {
        try {
            parent::notEmptyString($value);
        } catch (AssertionFailedException $e) {
            throw new StringInvalidArgumentInfrastructureException($value);
        }
    }

    public static function isString($string): void
    {
        try {
            parent::isString($string);
        } catch (AssertionFailedException $e) {
            throw new StringInvalidArgumentInfrastructureException($string);
        }
    }

    public static function isArray($array): void
    {
        try {
            BeberleiAssertion::isArray($array);
        } catch (AssertionFailedException $e) {
            throw new ArrayInvalidArgumentInfrastructureException($array);
        }
    }

    public static function notEmptyArray($array): void
    {
        try {
            self::isArray($array);
            parent::notEmpty($array);
        } catch (AssertionFailedException $e) {
            throw new ArrayInvalidArgumentInfrastructureException(json_encode($array));
        }
    }

    public static function isFloat($float): void
    {
        try {
            BeberleiAssertion::float($float);
        } catch (AssertionFailedException $e) {
            throw new FloatInvalidArgumentInfrastructureException($float);
        }
    }

    public static function isBoolean($boolean): void
    {
        try {
            BeberleiAssertion::boolean($boolean);
        } catch (AssertionFailedException $e) {
            throw new BooleanInvalidArgumentInfrastructureException($boolean);
        }
    }

    public static function isInteger($integer): void
    {
        try {
            BeberleiAssertion::integer($integer);
        } catch (AssertionFailedException $e) {
            throw new IntegerInvalidArgumentInfrastructureException($integer);
        }
    }

    public static function isIntegerPositive($value): void
    {
        try {
            parent::isIntegerPositive($value);
        } catch (AssertionFailedException $e) {
            throw new IntegerInvalidArgumentInfrastructureException($value);
        }
    }

    public static function isDate($date, string $format): void
    {
        try {
            BeberleiAssertion::date($date, $format);
        } catch (AssertionFailedException $e) {
            throw new DateInvalidArgumentInfrastructureException($date);
        }
    }

    public static function isUuid($value): void
    {
        try {
            parent::isUuid($value);
        } catch (AssertionFailedException $e) {
            throw new UuidInvalidArgumentInfrastructureException($value);
        }
    }

    public static function isEmptyArray($value): void
    {
        try {
            BeberleiAssertion::isArray($value);
            BeberleiAssertion::noContent($value);
        } catch (AssertionFailedException $e) {
            throw new ArrayInvalidArgumentInfrastructureException($value);
        }
    }

    public static function keyExists($value, string $key): void
    {
        try {
            BeberleiAssertion::keyExists($value, $key);
        } catch (AssertionFailedException $e) {
            throw new ArrayKeyInvalidArgumentInfrastructureException($key);
        }
    }

    public static function isNumeric($value): void
    {
        try {
            BeberleiAssertion::numeric($value);
        } catch (AssertionFailedException $e) {
            throw new StringInvalidArgumentInfrastructureException($value);
        }
    }
}
