<?php

namespace Omnipay\Encoded\Message\Order;

use Omnipay\Encoded\Message\AbstractRequest;
use Omnipay\Encoded\Message\Customer\CustomerResponse;

class OrderResponse extends \Omnipay\Encoded\Message\Response
{

    protected $customer_obj = null;

    public function isSuccessful()
    {
        return isset($this->data['id']);
    }

    public function getTransactionReference()
    {
        if (isset($this->data['ref'])) {
            return $this->data['ref'];
        }

        return null;
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function getDescription()
    {
        return $this->data['description'];
    }

    public function getHPPUrl()
    {
        return isset($this->data['links']['hpp'][AbstractRequest::API_VERSION]) ?
            $this->data['links']['hpp'][AbstractRequest::API_VERSION] : '';
    }

    public function getCreationDate()
    {
        return $this->data['creationDate'];
    }

    public function getCurrency()
    {
        return $this->data['currency'];
    }

    public function getAmount()
    {
        return $this->data['totalAmount'];
    }

    /**
     * @return CustomerResponse|null
     */
    public function getCustomer()
    {
        if (isset($this->data['billingCustomer'])) {
            $this->customer_obj = new CustomerResponse($this->request, $this->data['billingCustomer']);

            return $this->customer_obj;
        }


        return null;
    }
}
