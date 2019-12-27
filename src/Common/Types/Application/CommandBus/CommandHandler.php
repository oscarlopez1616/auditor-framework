<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus;

interface CommandHandler
{
    public function __invoke(Command $command): void;
}
