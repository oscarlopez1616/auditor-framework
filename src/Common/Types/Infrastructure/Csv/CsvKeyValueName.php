<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Csv;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\InvalidFileNameException;

abstract class CsvKeyValueName extends ValueObject
{
    /**
     * @var string
     */
    public $value;

    /**
     * @var Uuid
     */
    public $id;

    /**
     * CsvKeyValueName constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->guard($value);
        $this->value = $value;
        $this->id = $this->mapNameId($value);
    }

    abstract protected function mapNameId(string $value): Uuid;

    public function guard(string $value)
    {
        $valueWithFileType = $value.'.csv';
        preg_match('/^.+.csv$/', $valueWithFileType, $output_array);
        if( count($output_array) === 0 ){
            throw new InvalidFileNameException($value);
        }

        if (!in_array($value, $this->allowedValues())) {
            throw new InvalidFileNameException($value);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    abstract protected function allowedValues(): array;

    /**
     * @param ValueObject|CsvKeyValueName $o
     * @return bool
     */
    protected function equalValues(ValueObject $o): bool
    {
        return $this->value() === $o->value() && $this->id()->value() === $o->id()->value();
    }

}
