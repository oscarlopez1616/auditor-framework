<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\InvalidRoleException;

class Role extends ValueObject
{
    public const ROLE_SUPER_ADMIN = 'role_super_admin';
    public const ROLE_ADMIN = 'role_admin';
    public const ROLE_TASK_RUNNER = 'role_task_runner';


    private $allowedValues = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_ADMIN,
        self::ROLE_TASK_RUNNER
    ];

    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->guard($value);
        $this->setValue($value);
    }

    private function guard(string $value)
    {
        $this->guardValue($value);
    }

    private function guardValue(string $value)
    {
        if (!in_array($value, $this->allowedValues)) {
            throw new InvalidRoleException($value);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    private function setValue(string $value)
    {
        $this->value = $value;
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
