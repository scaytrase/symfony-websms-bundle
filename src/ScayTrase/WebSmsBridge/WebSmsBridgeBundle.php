<?php
/**
 * Created by PhpStorm.
 * User: batanov.pavel
 * Date: 21.07.2015
 * Time: 17:54
 */

namespace ScayTrase\WebSmsBridge;

use ScayTrase\WebSmsBridge\DependencyInjection\Compiler\WebSmsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class WebSmsBridgeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new WebSmsCompilerPass());
    }

}
