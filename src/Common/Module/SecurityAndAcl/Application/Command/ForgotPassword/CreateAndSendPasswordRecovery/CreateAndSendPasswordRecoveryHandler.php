<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ForgotPassword\CreateAndSendPasswordRecovery;

use AuditorFramework\Common\Types\Application\CommandBus\Command;
use AuditorFramework\Common\Types\Application\CommandBus\CommandHandler;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use Throwable;

class CreateAndSendPasswordRecoveryHandler implements CommandHandler
{
    /**
     * @var CreateAndSendPasswordRecoveryService
     */
    private $service;

    public function __construct(CreateAndSendPasswordRecoveryService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Command|CreateAndSendPasswordRecoveryCommand $command
     * @throws Throwable
     */
    public function __invoke(Command $command): void
    {
        $passwordRecoveryId = new PasswordRecoveryId($command->passwordRecoveryId());
        $userName = new UniqueEmail($command->userName());
        $this->service->execute($passwordRecoveryId, $userName);
    }
}
