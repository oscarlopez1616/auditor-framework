<?php


namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\UnblockUser;

use Doctrine\DBAL\ConnectionException;
use AuditorFramework\Common\Types\Application\CommandBus\Command;
use AuditorFramework\Common\Types\Application\CommandBus\CommandHandler;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use Throwable;

class UnblockUserHandler implements CommandHandler
{
    /**
     * @var UnblockUserService
     */
    private $service;

    public function __construct(UnblockUserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Command|UnblockUserCommand $command
     * @throws ConnectionException
     * @throws Throwable
     */
    public function __invoke(Command $command): void
    {
        $userId = new UserId($command->id());
        $this->service->execute($userId);
    }
}
