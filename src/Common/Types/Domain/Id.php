<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Utils\Assertion\DomainAssertion;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Id extends ValueObject
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    private function setValue(string $value)
    {
        $this->guard($value);

        $this->value = $value;
    }

    private function guard(string $value): void
    {

    }

    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @param self|ValueObject $o
     *
     * @return bool
     */
    protected function equalValues(ValueObject $o): bool
    {
        return $this->value() == $o->value();
    }
}
