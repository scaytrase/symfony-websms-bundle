<?php
/**
 * Created by PhpStorm.
 * User: batanov.pavel
 * Date: 21.07.2015
 * Time: 18:07
 */

namespace ScayTrase\WebSmsBridge\DependencyInjection;

use ScayTrase\WebSMS\Connection\AbstractWebSMSConnection;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('web_sms');

        $connection = (new ArrayNodeDefinition('connection'));
        $login = (new ScalarNodeDefinition('login'));
        $secret = (new ScalarNodeDefinition('secret'));

        $sendMode = (new ScalarNodeDefinition('mode'));
        $sendMode->defaultValue(AbstractWebSMSConnection::TEST_DISABLED);

        $connection
            ->children()
                ->append($login->info('login')->isRequired())
                ->append($secret->info('secret')->isRequired())
                ->append($sendMode->info('Test mode')->example(array(
                    '-1 for special testing (no auth checked)',
                    '1 for usual testing (no sending occurs, no charge for sending)',
                    '0 for production sending'
                )))

            ->end();

        $rootNode
            ->children()
                ->append($connection->info('WebSMS connection parameters'))
            ->end();

        return $treeBuilder;
    }
}
