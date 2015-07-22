<?php
/**
 * Created by PhpStorm.
 * User: batanov.pavel
 * Date: 21.07.2015
 * Time: 18:06
 */

namespace ScayTrase\WebSmsBridge\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class WebSmsBridgeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('websms.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->traverseConfig($container, $config, 'websms_bridge');
    }

    private function traverseConfig(ContainerBuilder $container, $config, $parentKey)
    {
        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $this->traverseConfig($container, $value, $parentKey . '.' . $key);
            } else {
                $container->setParameter($parentKey . '.' . $key, $value);
            }
        }
    }
}

