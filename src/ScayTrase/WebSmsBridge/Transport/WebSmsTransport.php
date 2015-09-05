<?php
/**
 * Created by PhpStorm.
 * User: batanov.pavel
 * Date: 21.07.2015
 * Time: 17:53
 */

namespace ScayTrase\WebSmsBridge\Transport;

use ScayTrase\SmsDeliveryBundle\Exception\DeliveryFailedException;
use ScayTrase\SmsDeliveryBundle\Service\ShortMessageInterface;
use ScayTrase\SmsDeliveryBundle\Transport\TransportInterface;
use ScayTrase\WebSMS\Connection\ConnectionInterface;
use ScayTrase\WebSmsBridge\Message\WebSmsMessage;

class WebSmsTransport implements TransportInterface
{
    /** @var  ConnectionInterface */
    private $connection;

    /**
     * WebSmsTransport constructor.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param ShortMessageInterface $message
     * @return boolean
     *
     * @throws DeliveryFailedException
     */
    public function send(ShortMessageInterface $message)
    {
        $webSmsMessage = new WebSmsMessage($message->getRecipient(), $message->getBody());

        return $this->connection->send($webSmsMessage);
    }
}
