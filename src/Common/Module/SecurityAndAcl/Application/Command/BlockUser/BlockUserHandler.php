<?php


namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\BlockUser;

use Doctrine\DBAL\ConnectionException;
use AuditorFramework\Common\Types\Application\CommandBus\Command;
use AuditorFramework\Common\Types\Application\CommandBus\CommandHandler;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use Throwable;

class BlockUserHandler implements CommandHandler
{
    /**
     * @var BlockUserService
     */
    private $service;

    public function __construct(BlockUserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Command|BlockUserCommand $command
     * @throws ConnectionException
     * @throws Throwable
     */
    public function __invoke(Command $command): void
    {
        $userId = new UserId($command->id());
        $this->service->execute($userId);
    }
}
