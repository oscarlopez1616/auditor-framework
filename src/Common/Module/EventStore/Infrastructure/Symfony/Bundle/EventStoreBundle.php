<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Infrastructure\Symfony\Bundle;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\EventStore\Infrastructure\Symfony\DependencyInjection\EventStoreExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EventStoreBundle extends Bundle
{
    protected function getContainerExtensionClass()
    {
        return EventStoreExtension::class;
    }
}
