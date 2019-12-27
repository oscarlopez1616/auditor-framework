<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\CreateUser;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\Command;

class CreateUserCommand implements Command
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var string
     */
    private $userType;

    public function __construct(
        string $id,
        string $userName,
        array $roles,
        string $password,
        bool $active,
        string $userType
    ) {
        $this->id = $id;
        $this->userName = $userName;
        $this->roles = $roles;
        $this->password = $password;
        $this->active = $active;
        $this->userType = $userType;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userName(): string
    {
        return $this->userName;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function active(): bool
    {
        return $this->active;
    }

    public function userType(): string
    {
        return $this->userType;
    }
}
