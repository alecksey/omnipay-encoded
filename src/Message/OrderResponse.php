<?php

namespace Omnipay\Encoded\Message;

class OrderResponse extends Response
{
    public function isSuccessful()
    {
        return isset($this->data['id']);
    }

    public function getTransactionReference()
    {
        if (isset($this->data['ref'])) {
            return $this->data['ref'];
        }
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
        return isset($this->data['links']['hpp'][AbstractRequest::API_VERSION]) ? $this->data['links']['hpp'][AbstractRequest::API_VERSION] : '';
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

    public function getCustomer()
    {

    }
}
