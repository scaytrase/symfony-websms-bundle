<?php
/**
 * Created by PhpStorm.
 * User: batanov.pavel
 * Date: 21.07.2015
 * Time: 17:53
 */

namespace ScayTrase\WebSmsBridge\Transport;

use Psr\Log\LoggerInterface;
use ScayTrase\SmsDeliveryBundle\Exception\DeliveryFailedException;
use ScayTrase\SmsDeliveryBundle\Service\ShortMessageInterface;
use ScayTrase\SmsDeliveryBundle\Transport\TransportInterface;
use ScayTrase\WebSMS\Connection\ConnectionInterface;

class WebSmsTransport implements TransportInterface
{
    /** @var  ConnectionInterface */
    private $connection;

    /** @var  LoggerInterface */
    private $logger = null;

    /**
     * WebSmsTransport constructor.
     * @param ConnectionInterface $connection
     * @param LoggerInterface|null $logger
     */
    public function __construct(ConnectionInterface $connection, LoggerInterface $logger = null)
    {
        $this->connection = $connection;
        $this->logger = $logger;
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

        $result = $this->connection->send($webSmsMessage);

        if ($this->logger) {
            $this->logger->info('WebSMS: Sending sms', ['recipient' => $message->getRecipient(), 'success' => $result]);
        }

        return $result;
    }
}
