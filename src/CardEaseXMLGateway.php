<?php

namespace Omnipay\Creditcall;

use Omnipay\Common\AbstractGateway;

/**
 * Creditcall CardEaseXML Gateway
 */
class CardEaseXMLGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Creditcall CardEaseXML';
    }

    public function getDefaultParameters()
    {
        return array(
            'key' => '',
            'testMode' => false,
        );
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    /**
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Creditcall\Message\AuthorizeRequest', $parameters);
    }
}
