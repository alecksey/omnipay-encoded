<?php

namespace Omnipay\Encoded;

use Omnipay\Common\AbstractGateway;

/**
 * Skeleton Gateway
 */
class ServerGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Encoded';
    }

    public function getDefaultParameters()
    {
        return array(
            'access_key' => '',
            'access_secret' => '',
            'testMode' => false,
        );
    }

    public function getAccessKey()
    {
        return $this->getParameter('access_key');
    }

    public function setAccessKey($value)
    {
        return $this->setParameter('access_key', $value);
    }

    public function getAccessSecret()
    {
        return $this->getParameter('key');
    }

    public function setAccessSecret($value)
    {
        return $this->setParameter('access_secret', $value);
    }

    /**
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Encoded\Message\AuthorizeRequest', $parameters);
    }

    public function createOrder(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Encoded\Message\CreateOrderRequest::class, $parameters);
    }
}
