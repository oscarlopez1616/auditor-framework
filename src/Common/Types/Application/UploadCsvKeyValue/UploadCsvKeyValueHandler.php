<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\UploadCsvKeyValue;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\Command;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\CommandHandler;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;
use Throwable;

class UploadCsvKeyValueHandler implements CommandHandler
{
    /**
     * @var UploadCsvKeyValueService
     */
    private $service;

    public function __construct(UploadCsvKeyValueService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Command|UploadCsvKeyValueCommand $command
     * @throws Throwable
     */
    public function __invoke(Command $command): void
    {
        $this->service->execute(
            new Uuid($command->id()),
            $command->data()
        );
    }
}
