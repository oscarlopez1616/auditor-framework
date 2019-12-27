<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application;

use Exception;
use Prooph\ServiceBus\CommandBus as ProophCommandBus;

class CommandBus
{
    /**
     * @var ProophCommandBus
     */
    private $commandBus;

    /**
     * CommandBus constructor.
     * @param ProophCommandBus $commandBus
     */
    public function __construct(ProophCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $command
     * @throws Exception
     */
    public function dispatch($command)
    {
        try {
            $this->commandBus->dispatch($command);
        } catch (Exception $e) {
            throw $e->getPrevious();
        }

    }

}
