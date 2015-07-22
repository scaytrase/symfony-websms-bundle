<?php
/**
 * Created by PhpStorm.
 * User: batanov.pavel
 * Date: 21.07.2015
 * Time: 17:57
 */

namespace ScayTrase\WebSmsBridge\Message;

use ScayTrase\WebSMS\Message\MessageInterface;

class WebSmsMessage implements MessageInterface
{
    /**
     * WebSmsMessage constructor.
     * @param string $recipient
     * @param string $message
     */
    public function __construct($recipient, $message)
    {
        $this->recipient = $recipient;
        $this->message = $message;
    }


    /**
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /** @var  string */
    private $recipient;
    /** @var  string */
    private $message;
}
