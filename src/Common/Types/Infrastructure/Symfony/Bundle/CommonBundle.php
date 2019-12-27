<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Symfony\Bundle;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Symfony\DependencyInjection\CommonExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CommonBundle extends Bundle
{
    protected function getContainerExtensionClass()
    {
        return CommonExtension::class;
    }
}
