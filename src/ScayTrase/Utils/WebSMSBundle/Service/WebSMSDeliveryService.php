<?php
/**
 * Created by PhpStorm.
 * User: Pavel Batanov <pavel@batanov.me>
 * Date: 30.06.2014
 * Time: 12:54
 */

namespace ScayTrase\Utils\WebSMSBundle\Service;


use ScayTrase\Utils\SMSDeliveryBundle\Exception\DeliveryFailedException;
use ScayTrase\Utils\SMSDeliveryBundle\Service\MessageDeliveryService;
use ScayTrase\Utils\SMSDeliveryBundle\Service\ShortMessageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WebSMSDeliveryService extends MessageDeliveryService
{
    private $base_url;
    private $template;
    private $login;
    private $password;
    private $sender_alias;

    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->login = $container->getParameter('websms.login');
        $this->password = $container->getParameter('websms.password');
        $this->sender_alias = $container->getParameter('websms.default_alias');
        $this->base_url = $container->getParameter('websms.base_url');
        $this->template = $container->getParameter('websms.template');
    }

    /**
     * Actually send message thru the messenger
     * @param ShortMessageInterface $message
     * @return bool
     * @throws DeliveryFailedException
     */
    protected function sendMessage(ShortMessageInterface $message)
    {
        $url = $this->buildApiUrl($message);

        $response = file_get_contents($url);
        return $this->processDeliveryResults($response);
    }

    private function processDeliveryResults($response)
    {
        return strpos($response, 'error_num=OK') !== false;
    }

    /**
     * @param ShortMessageInterface $message
     * @return string
     */
    private  function buildApiUrl(ShortMessageInterface $message)
    {
        return sprintf(
            $this->template,
            $this->base_url,
            $this->login,
            $this->password,
            $message->getRecipient(),
            $message->getBody()
        );
    }
}