<?php
/**
 * Created by PhpStorm.
 * User: Pavel Batanov <pavel@batanov.me>
 * Date: 30.07.2014
 * Time: 14:01
 */

namespace ScayTrase\Utils\WebSMSBundle\Tests;

use ScayTrase\Utils\SMSDeliveryBundle\DataCollector\MessageDeliveryDataCollector;
use ScayTrase\Utils\SMSDeliveryBundle\DependencyInjection\SMSDeliveryExtension;
use ScayTrase\Utils\SMSDeliveryBundle\Service\ShortMessageInterface;
use ScayTrase\Utils\WebSMSBundle\DependencyInjection\WebSMSExtension;
use ScayTrase\Utils\WebSMSBundle\Service\WebSMSDeliveryService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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


    public function testPublicService()
    {
        $delivery_extension = new SMSDeliveryExtension();
        $websms_extension = new WebSMSExtension();

        $container = $this->getContainer();

        $delivery_extension->load(array(array('disable_delivery' => true)), $container);
        $websms_extension->load(array(), $container);

        $sender = $container->get('sms_delivery.websms_sender');

        /** @var ShortMessageInterface|\PHPUnit_Framework_MockObject_MockObject $message */
        $message = $this->getMock('ScayTrase\Utils\SMSDeliveryBundle\Service\ShortMessageInterface');

        $this->assertTrue($sender->send($message));
    }

    public function testCollector()
    {
        $delivery_extension = new SMSDeliveryExtension();
        $websms_extension = new WebSMSExtension();

        $container = $this->getContainer();

        $delivery_extension->load(array(array('disable_delivery' => true)), $container);
        $websms_extension->load(array(), $container);

        $container->setParameter('sms_delivery.class', 'ScayTrase\Utils\WebSMSBundle\Service\WebSMSDeliveryService');
        /** @var WebSMSDeliveryService $sender */
        $sender = $container->get('sms_delivery.sender');

        $collector = new MessageDeliveryDataCollector($sender);


        /** @var ShortMessageInterface|\PHPUnit_Framework_MockObject_MockObject $message */
        $message = $this->getMock('ScayTrase\Utils\SMSDeliveryBundle\Service\ShortMessageInterface');

        $this->assertTrue($sender->send($message));
        $this->assertTrue($sender->send($message));

        $collector->collect(new Request(), new Response());

        $this->assertCount(2,$collector->getRecords());
        $this->assertEquals('ScayTrase\Utils\WebSMSBundle\Service\WebSMSDeliveryService',$collector->getService());
    }

    public function testConfigurationMerging()
    {
        $delivery_extension = new SMSDeliveryExtension();
        $websms_extension = new WebSMSExtension();

        $container = $this->getContainer();

        $delivery_extension->load(array(), $container);
        $websms_extension->load(array(), $container);

        $container->setParameter('sms_delivery.class', 'ScayTrase\Utils\WebSMSBundle\Service\WebSMSDeliveryService');

        $sender = $container->get('sms_delivery.sender');

        $this->assertInstanceOf('ScayTrase\Utils\WebSMSBundle\Service\WebSMSDeliveryService', $sender);
    }

    public function testSending()
    {
        $this->markTestIncomplete('Have to stub file_get_content');
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
}
 