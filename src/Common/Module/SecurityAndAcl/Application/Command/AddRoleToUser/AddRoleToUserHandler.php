<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\AddRoleToUser;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\Command;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\CommandHandler;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use Throwable;

class AddRoleToUserHandler implements CommandHandler
{
    /**
     * @var AddRoleToUserService
     */
    private $service;

    public function __construct(AddRoleToUserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Command|AddRoleToUserCommand $command
     * @throws Throwable
     */
    public function __invoke(Command $command): void
    {
        $userId = new UserId($command->id());
        $role = new Role($command->role());
        $this->service->execute($userId, $role);
    }
}
