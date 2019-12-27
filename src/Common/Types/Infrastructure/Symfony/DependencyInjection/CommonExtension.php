<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Symfony\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CommonExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.DIRECTORY_SEPARATOR.'Resources'));
        $this->loadServiceConfigurations($loader);
    }

    /**
     * @param YamlFileLoader $loader
     * @throws Exception
     */
    private function loadServiceConfigurations(YamlFileLoader $loader): void
    {
        $loader->load('common_extension.yaml');
    }
}
