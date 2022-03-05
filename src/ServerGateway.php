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
     * @param array $parameters
     * @return \Omnipay\Encoded\Message\Order\CreateOrderRequest
     */
    public function createOrder(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\Encoded\Message\Order\CreateOrderRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function createCustomer(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Encoded\Message\Customer\CreateCustomerRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Encoded\Message\Customer\GetCustomersRequest
     */
    public function getCustomers(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Encoded\Message\Customer\GetCustomersRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Encoded\Message\Order\GetOrderRequest
     */
    public function getOrder(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Encoded\Message\Order\GetOrderRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Encoded\Message\Order\GetOrderTransactionsRequest
     */
    public function getOrderTransactions(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Encoded\Message\Order\GetOrderTransactionsRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\Transaction\GetTransactionRequest
     */
    public function getTransaction(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\Encoded\Message\Transaction\GetTransactionRequest::class, $parameters);
    }
}
