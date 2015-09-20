<?php
/**
 * Created by PhpStorm.
 * User: batanov.pavel
 * Date: 21.07.2015
 * Time: 18:27
 */

namespace ScayTrase\WebSmsBridge\Tests;

use ScayTrase\SmsDeliveryBundle\Service\MessageDeliveryService;
use ScayTrase\SmsDeliveryBundle\Service\ShortMessageInterface;
use ScayTrase\SmsDeliveryBundle\SmsDeliveryBundle;
use ScayTrase\WebSMS\Connection\Connection;
use ScayTrase\WebSmsBridge\WebSmsBridgeBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class WebSmsTransportTest extends \PHPUnit_Framework_TestCase
{
    public function testSending()
    {
        $container = $this->buildContainer(
            array(
                new WebSmsBridgeBundle(),
                new SmsDeliveryBundle(),
            ),
            array(
                'sms_delivery' => array('transport' => 'sms_delivery.transport.websms'),
                'web_sms' =>
                    array(
                        'connection' =>
                            array(
                                'login' => 'test',
                                'secret' => 'test',
                                'mode' => Connection::TEST_SPECIAL
                            )
                    )
            )
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
        self::assertGreaterThan(0, $connection->getBalance());
    }

    /**
     * @param array $configs
     *
     * @param BundleInterface[] $bundles
     * @return ContainerBuilder
     */
    protected function buildContainer(array $bundles = array(), array $configs = array())
    {
        $container = new ContainerBuilder();

        foreach ($bundles as $bundle) {
            $bundle->build($container);
            $this->loadExtension($bundle, $container, $configs);
        }

        $container->compile();
        return $container;
    }

    /**
     * @param BundleInterface $bundle
     * @param ContainerBuilder $container
     * @param array $configs
     */
    protected function loadExtension(BundleInterface $bundle, ContainerBuilder $container, array $configs)
    {
        $extension = $bundle->getContainerExtension();
        if (!$extension)
            return;

        $config = array_key_exists($extension->getAlias(), $configs) ? $configs[$extension->getAlias()] : array();
        $extension->load(array($config), $container);
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
}
