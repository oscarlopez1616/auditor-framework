<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ChangePassword;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\Command;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\CommandHandler;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use Throwable;

class ChangePasswordHandler implements CommandHandler
{
    /**
     * @var ChangePasswordService
     */
    private $service;

    public function __construct(ChangePasswordService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Command|ChangePasswordCommand $command
     * @throws Throwable
     */
    public function __invoke(Command $command): void
    {
        $userName = new UniqueEmail($command->userName());
        $this->service->execute(
            $userName,
            $command->oldPassword(),
            $command->newPassword()
        );
    }
}
