<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;
use TheCodeFighters\Bundle\AuditorFramework\Common\Utils\Assertion\DomainAssertion;

class UniqueEmail extends ValueObject
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $email)
    {
        $this->guard($email);
        $this->value = strtolower($email);
    }

    private function guard(string $email): void
    {
        $this->guardValue($email);
    }

    private function guardValue(string $email): void
    {
        DomainAssertion::isValidEmail($email);
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
        return $this->value() === $o->value();
    }
}
