<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\NotInAllowedValuesException;

class CloudDocumentType extends ValueObject
{
    public const CSV_KEY_VALUE = 'csv_key_value';

    private const ALLOWED_VALUES = [
        self::CSV_KEY_VALUE
    ];

    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->guard($value);
        $this->value = $value;

    }

    private function guard(string $value): void
    {
        $this->guardValue($value);
    }

    private function guardValue(string $value): void
    {
        if (!in_array($value, self::ALLOWED_VALUES)) {
            throw new NotInAllowedValuesException($value, self::ALLOWED_VALUES);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param ValueObject|self $o
     *
     * @return bool
     */
    protected function equalValues(ValueObject $o): bool
    {
        return $this->value === $o->value();
    }
}
