<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Symfony\Bundle;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Symfony\DependencyInjection\SecurityAndAclExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SecurityAndAclBundle extends Bundle
{
    protected function getContainerExtensionClass()
    {
        return SecurityAndAclExtension::class;
    }
}
