<?php
/**
 * Created by PhpStorm.
 * User: batanov.pavel
 * Date: 21.07.2015
 * Time: 18:27
 */

namespace ScayTrase\WebSmsBridge\Tests;

use ScayTrase\SmsDeliveryBundle\DependencyInjection\Compiler\TransportCompilerPass;
use ScayTrase\SmsDeliveryBundle\DependencyInjection\SmsDeliveryExtension;
use ScayTrase\SmsDeliveryBundle\Service\MessageDeliveryService;
use ScayTrase\SmsDeliveryBundle\Service\ShortMessageInterface;
use ScayTrase\WebSMS\Connection\Connection;
use ScayTrase\WebSmsBridge\DependencyInjection\WebSmsBridgeExtension;
use Symfony\Bundle\SecurityBundle\Tests\Functional\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WebSmsTransportTest extends WebTestCase
{
    public function testSending()
    {
        $container = $this->buildContainer(
            array('transport' => 'sms_delivery.transport.websms'),
            array('connection' => array('login' => 'test', 'secret' => 'test', 'mode' => Connection::TEST_SPECIAL))
        );

        $this->assertEquals('test', $container->getParameter('websms_bridge.connection.login'));
        $this->assertEquals('test', $container->getParameter('websms_bridge.connection.secret'));
        $this->assertEquals(Connection::TEST_SPECIAL, $container->getParameter('websms_bridge.connection.mode'));

        $message = $this->getMessageMock();

        /** @var MessageDeliveryService $sender */
        $sender = $container->get('sms_delivery.sender');

        self::assertTrue($sender->send($message));

        $connection = $container->get('websms_bridge.connection');

        self::assertTrue($connection->verify());
        self::assertGreaterThan(0,$connection->getBalance());
    }

    /** @return ShortMessageInterface */
    protected function getMessageMock()
    {
        /** @var ShortMessageInterface|\PHPUnit_Framework_MockObject_MockObject $messageMock */
        $messageMock = $this->getMock('ScayTrase\SmsDeliveryBundle\Service\ShortMessageInterface');
        $messageMock
            ->expects($this->any())->method('getRecipient')->willReturn('+79994567890');
        $messageMock
            ->expects($this->any())->method('getBody')->willReturn('test message');
        return $messageMock;
    }

    /**
     * @param array|null $interfaceConfig
     * @param array|null $webSmsConfig
     * @return ContainerBuilder
     */
    protected function buildContainer(array $interfaceConfig = null, array $webSmsConfig = null)
    {
        $interfaceExtension = new SmsDeliveryExtension();
        $webSmsExtension = new WebSmsBridgeExtension();
        $container = new ContainerBuilder();
        $container->addCompilerPass(new TransportCompilerPass());
        $interfaceExtension->load(array((array)$interfaceConfig), $container);
        $webSmsExtension->load(array((array)$webSmsConfig), $container);

        $container->compile();
        return $container;
    }
}
