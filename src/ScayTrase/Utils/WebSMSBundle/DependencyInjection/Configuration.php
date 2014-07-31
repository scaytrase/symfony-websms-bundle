<?php

namespace ScayTrase\Utils\WebSMSBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('web_sms');

        $base_url = (new ScalarNodeDefinition('base_url'));
        $login = (new ScalarNodeDefinition('login'));
        $password = (new ScalarNodeDefinition('password'));
        $default_alias = (new ScalarNodeDefinition('default_alias'));
        $template = (new ScalarNodeDefinition('template'));
        $rootNode
            ->children()
            ->append($base_url->defaultValue('http://www.websms.ru/http_in6.asp')->info('Websms API base url'))
            ->append($login->defaultValue('')->info('WebSMS login'))
            ->append($password->defaultValue('')->info('WebSMS password'))
            ->append($default_alias->defaultValue('')->info('Sending Alias'))
            ->append($template->defaultValue('%%1$s?http_username=%%2$s&http_password=%%3$s&phone_list=%%4$s&message=%%5$s&format=txt')->info('Template to form API access url'))
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
