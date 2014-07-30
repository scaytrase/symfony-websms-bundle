<?php
/**
 * Created by PhpStorm.
 * User: Pavel Batanov <pavel@batanov.me>
 * Date: 30.07.2014
 * Time: 14:01
 */

namespace ScayTrase\Utils\WebSMSBundle\Tests;

use ScayTrase\Utils\SMSDeliveryBundle\DependencyInjection\ScayTraseUtilsSMSDeliveryExtension;
use ScayTrase\Utils\SMSDeliveryBundle\Service\MessageDeliveryService;
use ScayTrase\Utils\SMSDeliveryBundle\Service\ShortMessageInterface;
use ScayTrase\Utils\WebSMSBundle\DependencyInjection\ScayTraseUtilsWebSMSExtension;
use ScayTrase\Utils\WebSMSBundle\Service\WebSMSDeliveryService;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WebSMSDeliveryServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Root name of the configuration
     *
     * @var string
     */
    private $root;

    public function setUp()
    {
        parent::setUp();

        $this->root = "sms_delivery";
    }


    public function testPublicService(){
        $delivery_extension = new ScayTraseUtilsSMSDeliveryExtension();
        $websms_extension = new ScayTraseUtilsWebSMSExtension();

        $container = $this->getContainer();

        $delivery_extension->load(array(array('disable_delivery'=>true)), $container);
        $websms_extension->load(array(),$container);

        $sender = $container->get('sms_delivery.websms_sender');

        /** @var ShortMessageInterface|\PHPUnit_Framework_MockObject_MockObject $message */
        $message = $this->getMock('ScayTrase\Utils\SMSDeliveryBundle\Service\ShortMessageInterface');

        $this->assertTrue($sender->send($message));
    }

    public function testConfigurationMerging()
    {
        $delivery_extension = new ScayTraseUtilsSMSDeliveryExtension();
        $websms_extension = new ScayTraseUtilsWebSMSExtension();

        $container = $this->getContainer();

        $delivery_extension->load(array(), $container);
        $websms_extension->load(array(),$container);

        $container->setParameter('sms_delivery.class','ScayTrase\Utils\WebSMSBundle\Service\WebSMSDeliveryService');

        $sender = $container->get('sms_delivery.sender');

        $this->assertInstanceOf('ScayTrase\Utils\WebSMSBundle\Service\WebSMSDeliveryService',$sender);
    }


    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
}
 