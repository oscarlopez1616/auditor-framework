<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\CreateUser;

use AuditorFramework\Common\Types\Application\CommandBus\Command;
use AuditorFramework\Common\Types\Application\CommandBus\CommandHandler;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserType;
use Throwable;
use function Lambdish\Phunctional\map;

class CreateUserHandler implements CommandHandler
{
    /**
     * @var CreateUserService
     */
    private $service;

    public function __construct(CreateUserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Command|CreateUserCommand $command
     * @throws Throwable
     */
    public function __invoke(
        Command $command
    ): void {
        $user = User::create(
            new UserId($command->id()),
            new UniqueEmail($command->userName()),
            map(
                function (string $role): Role {
                    return new Role($role);
                },
                $command->roles()
            ),
            password_hash($command->password(), PASSWORD_ARGON2I),
            $command->active(),
            new UserType($command->userType())
        );
        $this->service->execute($user);
    }
}
