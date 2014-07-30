<?php

namespace ScayTrase\Utils\WebSMSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('scay_trase_utils_web_sms');

        $rootNode
            ->children()
            ->append((new ScalarNodeDefinition('base_url'))->defaultValue('http://www.websms.ru/http_in6.asp')->info('Websms API base url'))
            ->append((new ScalarNodeDefinition('login'))->defaultValue('')->info('WebSMS login'))
            ->append((new ScalarNodeDefinition('password'))->defaultValue('')->info('WebSMS password'))
            ->append((new ScalarNodeDefinition('default_alias'))->defaultValue('')->info('Sending Alias'))
            ->append((new ScalarNodeDefinition('template'))->defaultValue('%1$s?http_username=%2$s&http_password=%3$s&phone_list=%4$s&message=%5$s&format=txt')->info('Template to form API access url'))
            ->end()
        ;

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
