<?php
/**
 * Created by PhpStorm.
 * User: Pavel Batanov <pavel@batanov.me>
 * Date: 30.06.2014
 * Time: 12:54
 */

namespace ScayTrase\Utils\WebSMSBundle\Service;


use ScayTrase\Utils\SMSDeliveryBundle\Entity\ShortMessage;
use ScayTrase\Utils\SMSDeliveryBundle\Service\DeliveryFailedException;
use ScayTrase\Utils\SMSDeliveryBundle\Service\MessageDeliveryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WebSMSDelivery implements MessageDeliveryInterface
{
    private $base_url;
    private $template;
    private $login;
    private $password;
    private $sender_alias;

    function __construct(ContainerInterface $container)
    {
        $this->login = $container->getParameter('websms.login');
        $this->password = $container->getParameter('websms.password');
        $this->sender_alias = $container->getParameter('websms.default_alias');
        $this->base_url = $container->getParameter('websms.base_url');
        $this->template = $container->getParameter('websms.template');
    }

    /**
     * Actually send message thru the messenger
     * @param ShortMessage $message
     * @return bool
     * @throws DeliveryFailedException
     */
    public function sendMessage(ShortMessage $message)
    {
        $url = sprintf(
            $this->template,
            $this->base_url,
            $this->login,
            $this->password,
            $message->getRecipient(),
            $message->getBody()
        );

        $response = file_get_contents($url);
        return $this->processDeliveryResults($response);
    }

    private function processDeliveryResults($response)
    {
        return strpos($response,'error_num=OK') !== false;
    }
}