<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\InvalidUserTypeException;

class UserType extends ValueObject
{
    private const SUPER_ADMIN = 'super_admin';
    private const ADMIN = 'admin';
    private const TASK_RUNNER = 'task_runner';

    private $allowedValues = [
        self::SUPER_ADMIN,
        self::ADMIN,
        self::TASK_RUNNER
    ];

    /**
     * @var string
     */
    private $userType;


    public function __construct(string $userType)
    {
        $this->guard($userType);
        $this->userType = $userType;
    }

    private function guard(string $userType): void
    {
        if (!in_array($userType, $this->allowedValues)) {
            throw new InvalidUserTypeException($userType);
        }
    }

    public function userType(): string
    {
        return $this->userType;
    }

    /**
     * @param ValueObject|self $o
     *
     * @return bool
     */
    protected function equalValues(ValueObject $o): bool
    {
        return $this->userType() === $o->userType();
    }
}
