<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Utils\Assertion;

use Assert\Assertion as BeberleiAssertion;
use Assert\AssertionFailedException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\InvalidEmailException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\InvalidUuidException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\InvalidDateException;

class DomainAssertion extends Assertion
{

    public static function isString($string): void
    {
        try {
            parent::isString($string);
        } catch (AssertionFailedException $e) {
            throw new DomainAssertionFailedException($e->getMessage());
        }
    }

    public static function isPercentage($value): void
    {
        try {
            parent::isPercentage($value);
        } catch (AssertionFailedException $e) {
            throw new DomainAssertionFailedException($e->getMessage());
        }
    }

    public static function notEmpty($value): void
    {
        try {
            parent::notEmpty($value);
        } catch (AssertionFailedException $e) {
            throw new DomainAssertionFailedException($e->getMessage());
        }
    }

    public static function notEmptyString($value): void
    {
        try {
            parent::notEmpty($value);
        } catch (AssertionFailedException $e) {
            throw new DomainAssertionFailedException($e->getMessage());
        }
    }

    public static function isIntegerPositive($value): void
    {
        try {
            parent::isIntegerPositive($value);
        } catch (AssertionFailedException $e) {
            throw new DomainAssertionFailedException($value);
        }
    }

    public static function isValidDate(string $date, string $format): void
    {
        try {
            BeberleiAssertion::date($date, $format);
        } catch (AssertionFailedException $e) {
            throw new InvalidDateException($date);
        }
    }

    public static function isUuid($value): void
    {
        try {
            parent::isUuid($value);
        } catch (AssertionFailedException $e) {
            throw new InvalidUuidException($value);
        }
    }

    public static function isValidEmail(string $email): void
    {
        try {
            BeberleiAssertion::email($email);
        } catch (AssertionFailedException $e) {
            throw new InvalidEmailException($email);
        }
    }


    public static function isGreaterThan($value, $limit): void
    {
        try {
            BeberleiAssertion::greaterThan($value, $limit);
        } catch (AssertionFailedException $e) {
            throw new DomainAssertionFailedException($e->getMessage());
        }
    }

    public static function isGreaterOrEqualThan($value, $limit): void
    {
        try {
            BeberleiAssertion::greaterOrEqualThan($value, $limit);
        } catch (AssertionFailedException $e) {
            throw new DomainAssertionFailedException($e->getMessage());
        }
    }
}
