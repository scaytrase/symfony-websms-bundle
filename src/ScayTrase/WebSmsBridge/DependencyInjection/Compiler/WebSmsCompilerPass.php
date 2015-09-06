<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-09-06
 * Time: 21:27
 */

namespace ScayTrase\WebSmsBridge\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WebSmsCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('websms_bridge.connection')) {
            return;
        }

        $driverId = $container->getParameter('websms_bridge.connection.driver');

        if (!$container->hasDefinition($driverId)) {
            throw new \LogicException('Parameter "websms_bridge.connection.driver" should contain proper driver service ID');
        }

        $definition = $container->getDefinition($driverId);

        $connection = $container->getDefinition('websms_bridge.connection');
        $connection->replaceArgument(0, $definition);
        $connection->setSynthetic(false);
    }
}