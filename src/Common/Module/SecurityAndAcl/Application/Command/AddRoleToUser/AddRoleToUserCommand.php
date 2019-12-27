<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\AddRoleToUser;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\Command;

class AddRoleToUserCommand implements Command
{

    /** @var string */
    private $id;

    /** @var string */
    private $role;

    /**
     * AddRoleToUserCommand constructor.
     * @param string $id
     * @param string $role
     */
    public function __construct(string $id, string $role)
    {
        $this->id = $id;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function role(): string
    {
        return $this->role;
    }
}
